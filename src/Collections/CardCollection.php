<?php

namespace PHPoker\Poker\Collections;

use Illuminate\Support\Collection;
use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

class CardCollection extends Collection
{
    /** @var array<int, Card> */
    protected $items = [];

    /**
     * @param  array<Card|string>|string  $cards
     *
     * @throws CannotDetermineCardFace
     * @throws CannotDetermineCardSuit
     */
    public static function fromText(array|string $cards): CardCollection
    {
        if (is_string($cards)) {
            preg_match_all('/[AaKkQqJjTt98765432]{1}[Cc♣Dd♦Hh♥Ss♠]{1}(?=[ ,])*/u', $cards, $matches);
            $cards = $matches[0];
        }

        return self::make(array_map(fn (Card|string $card) => is_string($card) ? Card::fromText($card) : $card, $cards))->unique()->values();
    }

    /**
     * @param  array  $items
     */
    public static function make($items = []): static
    {
        return new CardCollection($items);
    }

    /**
     * @throws \Exception
     */
    public static function createDeck(): CardCollection
    {
        $deck = CardCollection::make();

        collect(CardSuit::cases())->each(function (CardSuit $suit) use (&$deck) {
            collect(CardFace::cases())->each(function (CardFace $face) use (&$deck, $suit) {
                $deck->push(new Card(face: $face, suit: $suit));
            });
        });

        return $deck->shuffle();
    }

    public function discard(CardCollection|array|string $cards): CardCollection
    {
        if (is_string($cards) || is_array($cards)) {
            $cards = CardCollection::fromText($cards);
        }

        return $this->filter(fn (Card $card) => $cards->holding($card) === false)->values();
    }

    public function sortByFaceValue(): CardCollection
    {
        return $this->sortBy(fn (Card $card) => $card->face->value)->values();
    }

    public function sortByFaceValueDesc(): CardCollection
    {
        return $this->sortByDesc(fn (Card $card) => $card->face->value)->values();
    }

    public function faces(): Collection
    {
        return collect($this->items)
            ->map(fn (Card $card) => $card->face)
            ->unique()
            ->values();
    }

    public function uniqueCards(): CardCollection
    {
        return $this->unique(fn (Card $card) => $card->toString());
    }

    public function suits(): Collection
    {
        return collect($this->items)
            ->map(fn (Card $card) => $card->suit)
            ->unique()
            ->values();
    }

    public function countSuits(): Collection
    {
        return collect($this->items)->map(fn (Card $card) => $card->suit)->countBy('name');
    }

    public function countFaces(): Collection
    {
        return collect($this->items)->map(fn (Card $card) => $card->face)->countBy('name');
    }

    public function holding(CardFace|CardSuit|Card $cardCategory): bool
    {
        $field = match (get_class($cardCategory)) {
            CardFace::class => 'face',
            CardSuit::class => 'suit',
            default => null
        };

        return $this->contains(
            fn (Card $card) => $field ? $cardCategory === $card->$field : $card->face === $cardCategory->face && $card->suit === $cardCategory->suit
        );
    }

    public function ofSuit(CardSuit $suit): CardCollection
    {
        return $this->fetch($suit);
    }

    public function ofFace(CardFace $face): CardCollection
    {
        return $this->fetch($face);
    }

    public function fetch(CardFace|CardSuit $cardCategory): CardCollection
    {
        $field = $cardCategory instanceof CardFace ? 'face' : 'suit';

        return $this->filter(fn (Card $card) => $cardCategory === $card->$field);
    }

    public function diffCards(CardCollection $madeHand): CardCollection
    {
        return $this->filter(fn (Card $card) => ! $madeHand?->contains($card))->values()->sortByFaceValueDesc();
    }

    public function toString(string $separator = ' '): string
    {
        return $this->map(fn (Card $card) => $card->toString())->implode(value: $separator);
    }

    public function toIntegers(): CardCollection
    {
        return $this->map(fn (Card $card) => $card->toInteger());
    }

    public function toHtml(string $separator = ' '): string
    {
        return $this->map(fn (Card $card) => $card->toHtml())->implode(value: $separator);
    }
}
