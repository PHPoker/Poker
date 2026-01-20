<?php

use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\HandRank;
use PHPoker\Poker\Evaluate\Evaluator;

/**
 * @param  array<string>  $cards
 * @return array<int>
 */
function card_integers(array $cards): array
{
    return array_map(static fn (string $card): int => Card::fromText($card)->toInteger(), $cards);
}

test('rankSixCards returns the best five-card rank from six cards', function () {
    $hand = card_integers(['9h', 'Ah', 'Kh', 'Qh', 'Jh', 'Th']);
    $bestFive = card_integers(['Ah', 'Kh', 'Qh', 'Jh', 'Th']);

    $expected = Evaluator::rankFiveCards(...$bestFive);
    $actual = Evaluator::rankSixCards($hand);

    expect($actual)->toBe($expected);
});

test('evaluateHand routes six-card hands through the six-card evaluator', function () {
    $hand = card_integers(['9h', 'Ah', 'Kh', 'Qh', 'Jh', 'Th']);

    expect(Evaluator::evaluateHand($hand))->toBe(HandRank::STRAIGHT_FLUSH);
});

test('rankHand routes six-card hands through the six-card evaluator', function () {
    $hand = card_integers(['9h', 'Ah', 'Kh', 'Qh', 'Jh', 'Th']);

    expect(Evaluator::rankHand($hand))->toBe(Evaluator::rankSixCards($hand));
});
