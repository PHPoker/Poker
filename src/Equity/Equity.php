<?php

declare(strict_types=1);

namespace PHPoker\Poker\Equity;

use PHPoker\Poker\Card;
use PHPoker\Poker\Collections\CardCollection;

final class Equity
{
    private const DEFAULT_ITERATIONS = 10000;

    /**
     * @param  array<CardCollection|array<int|string|Card>|string>  $hands
     * @param  CardCollection|array<int|string|Card>|string|null  $board
     * @param  CardCollection|array<int|string|Card>|string|null  $dead
     */
    public static function calculate(
        array $hands,
        CardCollection|array|string|null $board = null,
        int $iterations = self::DEFAULT_ITERATIONS,
        CardCollection|array|string|null $dead = null,
    ): EquityResult {
        if (! self::extensionAvailable()) {
            throw new \RuntimeException('The phpoker extension is required to calculate equity.');
        }

        if ($iterations <= 0) {
            throw new \InvalidArgumentException('Iterations must be greater than zero.');
        }

        if ($hands === []) {
            throw new \InvalidArgumentException('At least one hand is required.');
        }

        $normalizedHands = array_map(
            static fn (CardCollection|array|string $hand): array => self::normalizeCardsToIntegers($hand),
            $hands
        );

        $boardInts = self::normalizeCardsToIntegers($board);
        $deadInts = self::normalizeCardsToIntegers($dead);
        $handCount = count($normalizedHands[0]);

        if (count($boardInts) > 5) {
            throw new \InvalidArgumentException('Board cannot exceed 5 cards.');
        }

        if ($handCount === 0) {
            throw new \InvalidArgumentException('Hands cannot be empty.');
        }

        foreach ($normalizedHands as $hand) {
            if (count($hand) !== $handCount) {
                throw new \InvalidArgumentException('All hands must have the same number of cards.');
            }
        }

        self::guardUniqueCards($normalizedHands, $boardInts, $deadInts);

        return self::calculateWithExtension($normalizedHands, $boardInts, $deadInts, $iterations);
    }

    /**
     * @param  array<array<int>>  $hands
     * @param  array<int>  $board
     * @param  array<int>  $dead
     */
    private static function calculateWithExtension(array $hands, array $board, array $dead, int $iterations): EquityResult
    {
        $handStrings = array_map(
            static fn (array $hand): string => implode(' ', self::integersToCardStrings($hand)),
            $hands
        );

        $resultRaw = poker_calculate_equity(
            $handStrings,
            self::integersToCardStrings($board),
            $iterations,
            self::integersToCardStrings($dead)
        );

        $equities = array_map(
            static fn (array $equityResultArray, string $hand): EquityCalculation => new EquityCalculation(
                $hand,
                (float) $equityResultArray['equity'],
                (int) $equityResultArray['wins'],
                (int) $equityResultArray['ties'],
                $iterations
            ),
            $resultRaw,
            $handStrings
        );

        return new EquityResult(
            $equities,
            $iterations,
            CardCollection::fromIntegers($board),
            CardCollection::fromIntegers($dead)
        );
    }

    /**
     * @param  array<int>  $hand
     * @return array<string>
     */
    private static function integersToCardStrings(array $hand): array
    {
        return array_map(
            static fn (int $card): string => Card::fromInteger($card)->toString(),
            $hand
        );
    }

    /**
     * @param  CardCollection|array<int|string|Card>|string|null  $cards
     *
     * @phpstan-param  CardCollection|array<array-key, mixed>|string|null  $cards
     *
     * @return array<int>
     */
    private static function normalizeCardsToIntegers(CardCollection|array|string|null $cards): array
    {
        if ($cards === null) {
            return [];
        }

        if ($cards instanceof CardCollection) {
            return $cards->toIntegers()->all();
        }

        if (is_string($cards)) {
            return CardCollection::fromText($cards)->toIntegers()->all();
        }

        return array_reduce(
            $cards,
            static function (array $integers, mixed $card): array {
                $integers[] = match (true) {
                    $card instanceof Card => $card->toInteger(),
                    is_string($card) => Card::fromText($card)->toInteger(),
                    is_int($card) => $card,
                    default => throw new \InvalidArgumentException('Cards must be Card, string, or integer values.'),
                };

                return $integers;
            },
            []
        );
    }

    /**
     * @param  array<array<int>>  $hands
     * @param  array<int>  $board
     * @param  array<int>  $dead
     */
    private static function guardUniqueCards(array $hands, array $board, array $dead): void
    {
        $all = array_reduce(
            $hands,
            static fn (array $cards, array $hand): array => array_merge($cards, $hand),
            $board
        );

        $all = array_merge($all, $dead);

        if (count($all) !== count(array_unique($all))) {
            throw new \InvalidArgumentException('Duplicate cards detected across hands, board, or dead cards.');
        }
    }

    private static function extensionAvailable(): bool
    {
        return extension_loaded('phpoker') && function_exists('poker_calculate_equity');
    }
}
