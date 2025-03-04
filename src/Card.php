<?php

declare(strict_types=1);

namespace PHPoker\Poker;

use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

class Card implements \JsonSerializable
{
    public function __construct(
        public CardFace $face,
        public CardSuit $suit,
    ) {}

    public static function make(CardFace $face, CardSuit $suit): self
    {
        return new self(face: $face, suit: $suit);
    }

    public static function areEqual(Card $card1, Card $card2): bool
    {
        return $card1->face === $card2->face && $card1->suit === $card2->suit;
    }

    public function isEqualTo(Card $card): bool
    {
        return self::areEqual($this, $card);
    }

    /**
     * @throws CannotDetermineCardFace
     * @throws CannotDetermineCardSuit
     */
    public static function fromText(string $cardText): self
    {
        if (mb_strlen($cardText) !== 2) {
            throw new \InvalidArgumentException('Card text must be 2 characters');
        }

        $face = mb_substr($cardText, 0, 1);
        $suit = mb_substr($cardText, 1, 1);

        return new self(face: CardFace::fromText($face), suit: CardSuit::fromText($suit));
    }

    public static function fromInteger(int $cardValue): self
    {
        return new self(
            face: CardFace::fromCardInteger($cardValue),
            suit: CardSuit::fromCardInteger($cardValue),
        );
    }

    public function bitMask(): string
    {
        return sprintf('%016d', $this->face->valueBitMask()).
            $this->suit->bitMask().
            $this->face->rankBitMask().
            $this->face->primeBitMask();
    }

    public function toInteger(): int
    {
        return (int) bindec($this->bitMask());
    }

    public function toString(bool $useSuitSymbols = false): string
    {
        return $this->face->symbol().($useSuitSymbols ? $this->suit->symbol() : $this->suit->text());
    }

    public static function random(): self
    {
        return new self(
            CardFace::cases()[array_rand(CardFace::cases(), 1)],
            CardSuit::cases()[array_rand(CardSuit::cases(), 1)]
        );
    }

    public function toHtml(bool $useSuitSymbols = false): string
    {
        $suitColor = match ($this->suit) {
            CardSuit::SPADE => 'white',
            CardSuit::HEART => 'red-500',
            CardSuit::DIAMOND => 'blue-500',
            CardSuit::CLUB => 'green-500',
        };

        return '[ '.$this->face->symbol().'<span class="text-'.$suitColor.'">'.($useSuitSymbols ? $this->suit->symbol() : $this->suit->text()).'</span> ]';
    }

    public function jsonSerialize(bool $useSuitSymbols = false): string
    {
        return $this->toString($useSuitSymbols);
    }
}
