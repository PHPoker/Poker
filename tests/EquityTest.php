<?php

use PHPoker\Poker\Card;
use PHPoker\Poker\Collections\CardCollection;
use PHPoker\Poker\Equity\Equity;
use PHPoker\Poker\Equity\EquityCalculation;
use PHPoker\Poker\Equity\EquityResult;

function assert_equity_percent(EquityResult $result, int $index, float $expected, float $margin): void
{
    $equity = $result->equities[$index]->equity;
    expect($equity)->toBeGreaterThanOrEqual($expected - $margin);
    expect($equity)->toBeLessThanOrEqual($expected + $margin);
}

$iterations = 1000000;
$margin = 0.2;

test('equity preflop AA vs KK', function () use ($iterations, $margin) {
    $result = Equity::calculate(['Ah Ad', 'Kh Kd'], [], $iterations);

    expect($result)->toBeInstanceOf(EquityResult::class);
    assert_equity_percent($result, 0, 82.6, $margin);
    assert_equity_percent($result, 1, 17.3, $margin);
});

test('equity flop AK vs 22 on K72', function () use ($iterations, $margin) {
    $result = Equity::calculate(['Ah Kd', '2c 2h'], ['Kc', '7d', '2s'], $iterations);

    assert_equity_percent($result, 0, 1.9, $margin);
    assert_equity_percent($result, 1, 98.0, $margin);
});

test('equity turn JJ vs AT vs 78s on K-9-6-T', function () use ($iterations, $margin) {
    $result = Equity::calculate(['Jh Jd', 'As Td', '7h 8h'], ['Kc', '9d', '6s', 'Tc'], $iterations);

    assert_equity_percent($result, 0, 9.5, $margin);
    assert_equity_percent($result, 1, 0.0, $margin);
    assert_equity_percent($result, 2, 90.4, $margin);
});

test('equity river AQ vs 45 on A-4-7-2-5', function () use ($iterations) {
    $result = Equity::calculate(['Ah Qd', '4d 5h'], ['As', '4h', '7c', '2d', '5d'], $iterations);

    expect($result->equities[0]->equity)->toBe(0.0)
        ->and($result->equities[1]->equity)->toBe(100.0);
});

test('equity preflop 99 vs AK with ace dead', function () use ($iterations, $margin) {
    $result = Equity::calculate(['9h 9d', 'Ad Kh'], [], $iterations, ['As']);

    assert_equity_percent($result, 0, 59.3, $margin);
    assert_equity_percent($result, 1, 40.6, $margin);
});

test('equity preflop 99 vs AK without dead cards', function () use ($iterations, $margin) {
    $result = Equity::calculate(['9h 9d', 'Ad Kh'], [], $iterations);

    assert_equity_percent($result, 0, 54.8, $margin);
    assert_equity_percent($result, 1, 45.1, $margin);
});

test('dead cards reduce deck availability', function () use ($iterations) {
    $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    $suits = ['c', 'd', 'h', 's'];
    $used = ['9h', '9d', 'Ad', 'Kh'];
    $dead = [];

    foreach ($ranks as $rank) {
        foreach ($suits as $suit) {
            $card = $rank.$suit;
            if (in_array($card, $used, true)) {
                continue;
            }
            $dead[] = $card;
        }
    }

    expect(fn () => Equity::calculate(['9h 9d', 'Ad Kh'], [], $iterations, $dead))
        ->toThrow(\Exception::class, 'Not enough cards left in deck after removing used/dead cards');
});

test('equity accepts mixed input types', function () {
    $hand1 = CardCollection::fromText('As Ks');
    $hand2 = [Card::fromText('Jh'), Card::fromText('9c')->toInteger()];

    $result = Equity::calculate(
        hands: [$hand1, $hand2],
        board: ['2c', '3c', '4c', '5d', '9h'],
        iterations: 1
    );

    expect($result->equities)->toHaveCount(2);
    expect(array_sum(array_map(static fn (EquityCalculation $calculation): float => $calculation->equity, $result->equities)))
        ->toBe(100.0);
});

test('equity rejects invalid inputs', function () {
    expect(fn () => Equity::calculate(hands: [], iterations: 1))
        ->toThrow(\InvalidArgumentException::class, 'At least one hand is required.');

    expect(fn () => Equity::calculate(hands: [''], iterations: 1))
        ->toThrow(\InvalidArgumentException::class, 'Hands cannot be empty.');

    expect(fn () => Equity::calculate(hands: ['As Ks', 'Qs'], iterations: 1))
        ->toThrow(\InvalidArgumentException::class, 'All hands must have the same number of cards.');

    expect(fn () => Equity::calculate(hands: ['As Ks'], board: 'As Ks Qs Js Ts 9h', iterations: 1))
        ->toThrow(\InvalidArgumentException::class, 'Board cannot exceed 5 cards.');

    expect(fn () => Equity::calculate(hands: ['As Ks', 'As Qs'], iterations: 1))
        ->toThrow(\InvalidArgumentException::class, 'Duplicate cards detected across hands, board, or dead cards.');

    expect(fn () => Equity::calculate(hands: ['As Ks'], iterations: 0))
        ->toThrow(\InvalidArgumentException::class, 'Iterations must be greater than zero.');
});
