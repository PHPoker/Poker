<?php

use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

/**
 * Tests for the CardSuit enumeration.
 *
 * These tests verify that the CardSuit enum works correctly,
 * including all conversion methods and property access.
 */

// Test enum values
test('CardSuit returns correct values', function () {
    expect(CardSuit::CLUB->value)->toBe(0x8000)
        ->and(CardSuit::DIAMOND->value)->toBe(0x4000)
        ->and(CardSuit::HEART->value)->toBe(0x2000)
        ->and(CardSuit::SPADE->value)->toBe(0x1000);
});

// Test bit mask constants
test('CardSuit has correct bit mask constants', function () {
    expect(CardSuit::CLUB_BIT_MASK_VALUE)->toBe(8)
        ->and(CardSuit::DIAMOND_BIT_MASK_VALUE)->toBe(4)
        ->and(CardSuit::HEART_BIT_MASK_VALUE)->toBe(2)
        ->and(CardSuit::SPADE_BIT_MASK_VALUE)->toBe(1);
});

// Test fromText with valid inputs
test('CardSuit fromText parses text strings correctly', function (string $input, CardSuit $expected) {
    expect(CardSuit::fromText($input))->toBe($expected);
})->with('valid_suit_strings');

// Test fromText with invalid inputs
test('CardSuit fromText throws exception for invalid text', function (string $input, string $exceptionMsg) {
    expect(fn () => CardSuit::fromText($input))->toThrow(CannotDetermineCardSuit::class, $exceptionMsg);
})->with('invalid_suit_strings');

// Test fromInteger with valid inputs
test('CardSuit fromInteger converts suit values correctly', function (int $input, CardSuit $expected) {
    expect(CardSuit::fromInteger($input))->toBe($expected);
})->with('valid_suit_integers');

// Test fromInteger with invalid inputs
test('CardSuit throws exception for invalid integers', function (int $input) {
    expect(fn () => CardSuit::fromInteger($input))->toThrow(CannotDetermineCardSuit::class);
})->with('invalid_suit_integers');

// Test fromCardInteger with valid inputs
test('CardSuit extracts suit from encoded card values', function (int $cardValue, CardSuit $expectedSuit, CardFace $expectedFace) {
    expect(CardSuit::fromCardInteger($cardValue))->toBe($expectedSuit);
})->with('valid_card_integers');

test('CardSuit bitMask returns correct binary representation', function (CardSuit $suit, string $expected) {
    expect($suit->bitMask())->toBe($expected);
})->with('suit_bitmasks');

test('CardSuit symbol returns correct Unicode character', function (CardSuit $suit, string $expected) {
    expect($suit->symbol())->toBe($expected);
})->with('suit_symbols');

test('CardSuit text returns correct single character', function (CardSuit $suit, string $expected) {
    expect($suit->text())->toBe($expected);
})->with('suit_texts');

test('CardSuit random returns a valid suit', function () {
    // Simply verify that random returns a valid CardSuit instance
    $randomSuit = CardSuit::random();
    expect($randomSuit)->toBeInstanceOf(CardSuit::class)
        ->and(in_array($randomSuit, CardSuit::cases()))->toBeTrue();
});
