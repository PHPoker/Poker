<?php

declare(strict_types=1);

namespace PHPoker\Poker\Collections;

use Illuminate\Support\Collection;
use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\CardFace;
use PHPoker\Poker\Enum\CardSuit;
use PHPoker\Poker\Enum\HandRank;
use PHPoker\Poker\Evaluate\Evaluator;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

/**
 * @extends Collection<int, Card>
 */
final class CardCollection extends Collection
{
    /** @var array<int, Card> */
    protected $items = [];

    /**
     * @param  array<Card|string>|string  $cards
     *
     * @throws CannotDetermineCardFace
     * @throws CannotDetermineCardSuit
     */
    public static function fromText(array|string $cards): self
    {
        if (is_string($cards)) {
            preg_match_all('/[AaKkQqJjTt98765432]{1}[Cc♣Dd♦Hh♥Ss♠]{1}(?=[ ,])*/u', $cards, $matches);
            $cards = $matches[0];
        }

        return self::make(array_map(static fn (Card|string $card): Card => is_string($card) ? Card::fromText($card) : $card, $cards))->unique()->values();
    }

    /**
     * @param  array<int>  $cards
     */
    public static function fromIntegers(array $cards): self
    {
        return self::make(array_map(static fn (int $card): Card => Card::fromInteger($card), $cards))->unique()->values();
    }

    /**
     * @param  array<int, Card>  $items
     */
    public static function make($items = []): static
    {
        return new self($items);
    }

    public function evaluateHandRank(): HandRank
    {
        return Evaluator::evaluateHand($this->toIntegers()->all());
    }

    public function rankHand(): int
    {
        return Evaluator::rankHand($this->toIntegers()->all());
    }

    /**
     * @throws \Exception
     */
    public static function createDeck(): self
    {
        $deck = self::make();

        collect(CardSuit::cases())->each(function (CardSuit $suit) use (&$deck): void {
            collect(CardFace::cases())->each(function (CardFace $face) use (&$deck, $suit): void {
                $deck->push(new Card(face: $face, suit: $suit));
            });
        });

        return $deck->shuffle();
    }

    /**
     * @param  CardCollection|array<int, string|Card>|string  $cards
     *
     * @throws CannotDetermineCardFace
     * @throws CannotDetermineCardSuit
     */
    public function discard(self|array|string $cards): self
    {
        if (is_string($cards) || is_array($cards)) {
            $cards = self::fromText($cards);
        }

        return $this->filter(fn (Card $card): bool => $cards->holding($card) === false)->values();
    }

    public function sortByFaceValue(): self
    {
        return $this->sortBy(fn (Card $card): int => $card->face->value)->values();
    }

    public function sortByFaceValueDesc(): self
    {
        return $this->sortByDesc(fn (Card $card): int => $card->face->value)->values();
    }

    /**
     * @return \Illuminate\Support\Collection<int, CardFace>
     */
    public function faces(): Collection
    {
        return collect($this->items)
            ->map(fn (Card $card): CardFace => $card->face)
            ->unique()
            ->values();
    }

    public function uniqueCards(): self
    {
        return $this->unique(fn (Card $card): string => $card->toString());
    }

    /**
     * @return \Illuminate\Support\Collection<int, CardSuit>
     */
    public function suits(): Collection
    {
        return collect($this->items)
            ->map(fn (Card $card): CardSuit => $card->suit)
            ->unique()
            ->values();
    }

    /**
     * @return \Illuminate\Support\Collection<string, int>
     */
    public function countSuits(): Collection
    {
        return collect($this->items)->map(fn (Card $card): CardSuit => $card->suit)->countBy('name');
    }

    /**
     * @return \Illuminate\Support\Collection<string, int>
     */
    public function countFaces(): Collection
    {
        return collect($this->items)->map(fn (Card $card): CardFace => $card->face)->countBy('name');
    }

    public function holding(CardFace|CardSuit|Card $cardCategory): bool
    {
        if ($cardCategory instanceof CardFace) {
            return $this->contains(fn (Card $card): bool => $cardCategory === $card->face);
        }

        if ($cardCategory instanceof CardSuit) {
            return $this->contains(fn (Card $card): bool => $cardCategory === $card->suit);
        }

        return $this->contains(
            fn (Card $card): bool => $card->face === $cardCategory->face && $card->suit === $cardCategory->suit
        );
    }

    public function ofSuit(CardSuit $suit): self
    {
        return $this->fetch($suit);
    }

    public function ofFace(CardFace $face): self
    {
        return $this->fetch($face);
    }

    public function fetch(CardFace|CardSuit $cardCategory): self
    {
        $field = $cardCategory instanceof CardFace ? 'face' : 'suit';

        return $this->filter(fn (Card $card): bool => $cardCategory === $card->$field);
    }

    public function diffCards(self $madeHand): self
    {
        return $this->filter(fn (Card $card): bool => ! $madeHand->contains($card))->values()->sortByFaceValueDesc();
    }

    public function toString(string $separator = ' '): string
    {
        return $this->map(fn (Card $card): string => $card->toString())->implode(value: $separator);
    }

    /**
     * @return \Illuminate\Support\Collection<int, int>
     */
    public function toIntegers(): Collection
    {
        return collect($this->items)->map(fn (Card $card): int => $card->toInteger());
    }

    public function toHtml(string $separator = ' '): string
    {
        return $this->map(fn (Card $card): string => $card->toHtml())->implode(value: $separator);
    }
}
