<?php

use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;

test('CardFace has correct values', function () {
    expect(CardFace::TWO->value)->toBe(0)
        ->and(CardFace::THREE->value)->toBe(1)
        ->and(CardFace::FOUR->value)->toBe(2)
        ->and(CardFace::FIVE->value)->toBe(3)
        ->and(CardFace::SIX->value)->toBe(4)
        ->and(CardFace::SEVEN->value)->toBe(5)
        ->and(CardFace::EIGHT->value)->toBe(6)
        ->and(CardFace::NINE->value)->toBe(7)
        ->and(CardFace::TEN->value)->toBe(8)
        ->and(CardFace::JACK->value)->toBe(9)
        ->and(CardFace::QUEEN->value)->toBe(10)
        ->and(CardFace::KING->value)->toBe(11)
        ->and(CardFace::ACE->value)->toBe(12);
});

test('CardFace parses text representations', function (string $input, CardFace $expected) {
    expect(CardFace::fromText($input))->toBe($expected);
})->with('valid_face_strings');

test('CardFace throws exception for invalid text representations', function (string $input) {
    expect(fn () => CardFace::fromText('P'))->toThrow(CannotDetermineCardFace::class);
})->with([
    'Empty string' => [''],
    'Invalid face' => ['P'],
    'Symbol' => ['#'],
]);

test('CardFace fromInteger converts face values correctly', function (int $input, CardFace $expected) {
    expect(CardFace::fromInteger($input))->toBe($expected);
})->with('valid_face_integers');

test('CardFace fromInteger throws exception for invalid integers', function (int $input) {
    expect(fn () => CardFace::fromInteger($input))->toThrow(CannotDetermineCardFace::class);
})->with('invalid_face_integers');

test('CardFace extracts face from encoded card values', function (int $cardValue, CardSuit $expectedSuit, CardFace $expectedFace) {
    expect(CardFace::fromCardInteger($cardValue))->toBe($expectedFace);
})->with('valid_card_integers');

test('CardFace fromCardInteger throws exception for invalid card integers', function (int $cardValue) {
    // Create an invalid face value (15 << 8) in the bit pattern
    $invalidCard = $cardValue | (15 << 8);
    expect(fn () => CardFace::fromCardInteger($invalidCard))->toThrow(CannotDetermineCardFace::class);
})->with([0x1000, 0x2000, 0x4000, 0x8000]); // Test with each suit bit

test('CardFace prime returns correct prime number', function (CardFace $face, int $expected) {
    expect($face->prime())->toBe($expected);
})->with('face_prime_numbers');

test('CardFace returns correct prime binary representation', function (CardFace $face, string $expected) {
    expect($face->primeBitMask())->toBe($expected);
})->with('face_prime_bitmasks');

test('CardFace returns correct mask value', function (CardFace $face, int $expected) {
    expect($face->maskValue())->toBe($expected);
})->with('face_mask_values');

test('CardFace returns correct value binary representation', function (CardFace $face, string $expected) {
    expect($face->valueBitMask())->toBe($expected);
})->with('face_value_bitmasks');

test('CardFace returns correct rank binary representation', function (CardFace $face, string $expected) {
    expect($face->rankBitMask())->toBe($expected);
})->with('face_rank_bitmasks');

test('CardFace returns correct character', function (CardFace $face, string $expected) {
    expect($face->symbol())->toBe($expected);
})->with('face_symbols');

test('CardFace returns correct rank value', function (CardFace $face, int $expected) {
    expect($face->faceValue())->toBe($expected);
})->with('face_values');

test('CardFace returns ace as 1 when low is true', function () {
    expect(CardFace::ACE->faceValue(true))->toBe(1);
});

// Test the plus method with dataset
test('CardFace plus method increments face correctly', function (CardFace $face, int $increment, CardFace $expected) {
    expect($face->plus($increment))->toBe($expected);
})->with('face_plus_increments');

// Test the symbols method
test('CardFace returns array of all symbols', function () {
    $symbols = CardFace::symbols();
    expect($symbols)->toBeArray()
        ->and($symbols)->toHaveCount(13)
        ->and($symbols[0])->toBe('2')
        ->and($symbols[1])->toBe('3')
        ->and($symbols[2])->toBe('4')
        ->and($symbols[3])->toBe('5')
        ->and($symbols[4])->toBe('6')
        ->and($symbols[5])->toBe('7')
        ->and($symbols[6])->toBe('8')
        ->and($symbols[7])->toBe('9')
        ->and($symbols[8])->toBe('T')
        ->and($symbols[9])->toBe('J')
        ->and($symbols[10])->toBe('Q')
        ->and($symbols[11])->toBe('K')
        ->and($symbols[12])->toBe('A');
});

test('CardFace enum values can be accessed through invoke syntax', function () {
    expect(CardFace::TWO())->toBe(0)
        ->and(CardFace::THREE())->toBe(1)
        ->and(CardFace::FOUR())->toBe(2)
        ->and(CardFace::FIVE())->toBe(3)
        ->and(CardFace::SIX())->toBe(4)
        ->and(CardFace::SEVEN())->toBe(5)
        ->and(CardFace::EIGHT())->toBe(6)
        ->and(CardFace::NINE())->toBe(7)
        ->and(CardFace::TEN())->toBe(8)
        ->and(CardFace::JACK())->toBe(9)
        ->and(CardFace::QUEEN())->toBe(10)
        ->and(CardFace::KING())->toBe(11)
        ->and(CardFace::ACE())->toBe(12);
});

test('CardFace returns enum names correctly', function () {
    expect(CardFace::names())->toContain('TWO', 'THREE', 'FOUR', 'FIVE', 'SIX', 'SEVEN', 'EIGHT', 'NINE', 'TEN', 'JACK', 'QUEEN', 'KING', 'ACE');
});

// Test that values can be retrieved via the Values trait
test('CardFace returns enum values correctly', function () {
    expect(CardFace::values())->toContain(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
});

test('CardFace returns enum name/value pairs correctly', function () {
    $options = CardFace::options();
    expect($options)->toBeArray()
        ->and($options)->toHaveCount(13)
        ->and($options['TWO'])->toBe(0)
        ->and($options['THREE'])->toBe(1)
        ->and($options['FOUR'])->toBe(2)
        ->and($options['FIVE'])->toBe(3)
        ->and($options['SIX'])->toBe(4)
        ->and($options['SEVEN'])->toBe(5)
        ->and($options['EIGHT'])->toBe(6)
        ->and($options['NINE'])->toBe(7)
        ->and($options['TEN'])->toBe(8)
        ->and($options['JACK'])->toBe(9)
        ->and($options['QUEEN'])->toBe(10)
        ->and($options['KING'])->toBe(11)
        ->and($options['ACE'])->toBe(12);
});
