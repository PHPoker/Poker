<?php

use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

test('Card can be parsed via text', function (string $cardText, bool $useSuitSymbol, Card $expectedCard) {
    $card = Card::fromText($cardText);
    expect($card->isEqualTo($expectedCard))->toBeTrue();
})->with('card_text_strings');

test('Card gracefully handles text parsing errors', function () {
    expect(fn () => Card::fromText('Ps'))->toThrow(CannotDetermineCardFace::class);
    expect(fn () => Card::fromText('Ax'))->toThrow(CannotDetermineCardSuit::class);
    expect(fn () => Card::fromText('A♠♠'))->toThrow(\InvalidArgumentException::class);
});

test('Card bitmasks and integer values are correct', function (Card $card) {
    expect(Card::fromInteger($card->toInteger())->isEqualTo($card))->toBeTrue();
})->with('deck_of_cards');

test('Card equality methods are correct', function (Card $expectedCard) {
    $card = Card::make(face: $expectedCard->face, suit: $expectedCard->suit);
    expect($card->isEqualTo($expectedCard))->toBeTrue();
    expect(Card::areEqual($card, $expectedCard))->toBeTrue();
})->with('deck_of_cards');

test('Card random returns a valid card', function () {
    $randomCard = Card::random();
    expect($randomCard->face)->toBeInstanceOf(CardFace::class)
        ->and($randomCard->suit)->toBeInstanceOf(CardSuit::class)
        ->and(in_array($randomCard->face, CardFace::cases()))->toBeTrue()
        ->and(in_array($randomCard->suit, CardSuit::cases()))->toBeTrue();
});

test('Card outputs correct HTML representation', function (Card $card, bool $useSuitSymbol, string $expectedHtml) {
    expect($card->toHtml($useSuitSymbol))->toBe($expectedHtml);
})->with('card_html_strings');

test('Card outputs correct text representation', function (string $expectedText, bool $useSuitSymbol, Card $card) {
    expect($card->jsonSerialize($useSuitSymbol))->toBe($expectedText);
})->with('card_text_strings');
