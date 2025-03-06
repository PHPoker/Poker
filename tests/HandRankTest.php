<?php

use PHPoker\Poker\Enum\HandRank;

test('HandRank has correct values', function (HandRank $rank, int $expected) {
    expect($rank->value)->toBe($expected);
})->with('hand_rank_values');

test('HandRank evaluate method returns correct hand rank for hand values', function (
    int $handValue,
    HandRank $expectedRank
) {
    $rank = HandRank::evaluate($handValue);
    expect($rank)->toBe($expectedRank);
})->with('hand_rank_evaluations');

test('HandRank enum values can be accessed through invoke syntax', function () {
    expect(HandRank::STRAIGHT_FLUSH())->toBe(1)
        ->and(HandRank::FOUR_OF_A_KIND())->toBe(2)
        ->and(HandRank::FULL_HOUSE())->toBe(3)
        ->and(HandRank::FLUSH())->toBe(4)
        ->and(HandRank::STRAIGHT())->toBe(5)
        ->and(HandRank::THREE_OF_A_KIND())->toBe(6)
        ->and(HandRank::TWO_PAIR())->toBe(7)
        ->and(HandRank::ONE_PAIR())->toBe(8)
        ->and(HandRank::HIGH_CARD())->toBe(9);
});

test('HandRank returns enum names correctly', function () {
    expect(HandRank::names())->toContain('STRAIGHT_FLUSH', 'FOUR_OF_A_KIND', 'FULL_HOUSE', 'FLUSH', 'STRAIGHT', 'THREE_OF_A_KIND', 'TWO_PAIR', 'ONE_PAIR', 'HIGH_CARD');
});

test('HandRank returns enum values correctly', function () {
    expect(HandRank::values())->toContain(1, 2, 3, 4, 5, 6, 7, 8, 9);
});

test('HandRank returns enum options correctly', function () {
    $options = HandRank::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(9)
        ->and($options['STRAIGHT_FLUSH'])->toBe(1)
        ->and($options['FOUR_OF_A_KIND'])->toBe(2)
        ->and($options['FULL_HOUSE'])->toBe(3)
        ->and($options['FLUSH'])->toBe(4)
        ->and($options['STRAIGHT'])->toBe(5)
        ->and($options['THREE_OF_A_KIND'])->toBe(6)
        ->and($options['TWO_PAIR'])->toBe(7)
        ->and($options['ONE_PAIR'])->toBe(8)
        ->and($options['HIGH_CARD'])->toBe(9);
});
