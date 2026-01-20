<?php

declare(strict_types=1);

namespace PHPoker\Poker\Evaluate;

use PHPoker\Poker\Card;
use PHPoker\Poker\Enum\HandRank;
use PHPoker\Poker\Exceptions\InvalidNumberOfCardsInHand;

/**
 * The FastEvaluator and related classes are a direct port of Kevin "CactusKev" Suffecool's
 * C algorithm, and its perfect-hash improvements by Paul Senzee.
 *
 * PHP does not have unsigned integer type, which led to invalid indexes during the
 * perfectHash lookup. To get around this, I had to use some extra bitwise operations to simulate the way
 * C overflows 32-bit unsigned integers within PHP.
 *
 * I also added PHP support for 6 card evaluations (ex. turn card),
 * Since there are only 5 permutations I did not bother adding to the extension, performance win is negligible
 *
 * For more information on how this algorithm works under the hood, please visit:
 *
 * http://suffe.cool/poker/evaluator.html
 * https://senzee.blogspot.com/2006/06/some-perfect-hash.html
 */
class Evaluator
{
    private static ?bool $extensionAvailable = null;

    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function evaluateHand(array $hand): HandRank
    {
        $count = count($hand);

        if ($count !== 5 && $count !== 6 && $count !== 7) {
            throw new InvalidNumberOfCardsInHand($hand);
        }

        if (($count === 5 || $count === 7) && self::extensionAvailable()) {
            $value = self::normalizeExtensionHandValue(
                poker_evaluate_hand(self::integersToCardString($hand))
            );

            if ($value !== null) {
                return HandRank::evaluate($value);
            }
        }

        return HandRank::evaluate(match ($count) {
            5 => self::rankFiveCards(...$hand),
            6 => self::rankSixCards($hand),
            7 => self::rankSevenCards($hand),
        });
    }

    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function rankHand(array $hand): int
    {
        $count = count($hand);

        if ($count !== 5 && $count !== 6 && $count !== 7) {
            throw new InvalidNumberOfCardsInHand($hand);
        }

        if (($count === 5 || $count === 7) && self::extensionAvailable()) {
            $value = self::normalizeExtensionHandValue(
                poker_evaluate_hand(self::integersToCardString($hand))
            );

            if ($value !== null) {
                return $value;
            }
        }

        // for 6-card hands, we just use the PHP implementation; there are only 5 permutations

        return match ($count) {
            5 => self::rankFiveCards(...$hand),
            6 => self::rankSixCards($hand),
            7 => self::rankSevenCards($hand),
        };
    }

    public static function rankFiveCards(int $card1, int $card2, int $card3, int $card4, int $card5): int
    {
        $q = ($card1 | $card2 | $card3 | $card4 | $card5) >> 16;

        // This checks for Flushes and Straight Flushes
        if (($card1 & $card2 & $card3 & $card4 & $card5 & 0xF000) !== 0) {
            return EvaluatorLookups::FLUSH_HAND_LOOKUP[$q];
        }

        // This checks for Straights and High Card hands
        $s = EvaluatorLookups::HANDS_WITH_UNIOUE_FACES[$q] ?? null;

        if ($s) {
            return $s;
        }

        // This performs a perfect-hash lookup for remaining hands
        $q = ($card1 & 0xFF) * ($card2 & 0xFF) * ($card3 & 0xFF) * ($card4 & 0xFF) * ($card5 & 0xFF);

        return EvaluatorLookups::REMAINING_HAND_LOOKUP[self::perfectHash($q)];
    }

    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function rankSixCards(array $hand): int
    {
        if (count($hand) !== 6) {
            throw new InvalidNumberOfCardsInHand($hand);
        }

        $bestRank = 9999;

        for ($comboIndex = 0; $comboIndex < 6; $comboIndex++) {
            $fiveCardIndexes = EvaluatorLookups::SIX_HAND_PERMUTATIONS[$comboIndex];

            $handRank = self::rankFiveCards(
                $hand[$fiveCardIndexes[0]],
                $hand[$fiveCardIndexes[1]],
                $hand[$fiveCardIndexes[2]],
                $hand[$fiveCardIndexes[3]],
                $hand[$fiveCardIndexes[4]],
            );

            if ($handRank < $bestRank) {
                $bestRank = $handRank;
            }
        }

        return $bestRank;
    }

    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function rankSevenCards(array $hand): int
    {
        if (count($hand) !== 7) {
            throw new InvalidNumberOfCardsInHand($hand);
        }

        $bestRank = 9999;

        for ($comboIndex = 0; $comboIndex < 21; $comboIndex++) {
            $fiveCardIndexes = EvaluatorLookups::SEVEN_HAND_PERMUTATIONS[$comboIndex];

            $handRank = self::rankFiveCards(
                $hand[$fiveCardIndexes[0]],
                $hand[$fiveCardIndexes[1]],
                $hand[$fiveCardIndexes[2]],
                $hand[$fiveCardIndexes[3]],
                $hand[$fiveCardIndexes[4]],
            );

            if ($handRank < $bestRank) {
                $bestRank = $handRank;
            }
        }

        return $bestRank;
    }

    protected static function perfectHash(int $u): int
    {
        $u += 0xE91AAA35;
        $u ^= ($u >> 16);
        $u = ($u + (($u << 8) % 0x100000000)) % 0x100000000;
        $u ^= $u >> 4;
        $b = ($u >> 8) & 0x1FF;
        $a = (($u + ($u << 2)) % 0x100000000) >> 19;

        return $a ^ EvaluatorLookups::PERFECT_HASH_LOOKUP[$b];
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

    private static function normalizeExtensionHandValue(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_float($value) || (is_string($value) && is_numeric($value))) {
            return (int) $value;
        }

        if (is_array($value)) {
            $keys = ['value', 'handValue', 'hand_value', 'rank', 'hand_rank'];

            foreach ($keys as $key) {
                if (array_key_exists($key, $value) && is_numeric($value[$key])) {
                    return (int) $value[$key];
                }
            }

            if (array_is_list($value) && $value !== [] && is_numeric($value[0])) {
                return (int) $value[0];
            }
        }

        return null;
    }

    /**
     * @param  array<int>  $hand
     */
    private static function integersToCardString(array $hand): string
    {
        return implode(' ', self::integersToCardStrings($hand));
    }

    private static function extensionAvailable(): bool
    {
        if (self::$extensionAvailable === null) {
            self::$extensionAvailable = extension_loaded('phpoker') && function_exists('poker_evaluate_hand');
        }

        return self::$extensionAvailable;
    }
}
