<?php

declare(strict_types=1);

namespace PHPoker\Poker\Evaluate;

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
 * For more information how this algorithm works under the hood, please visit:
 *
 * http://suffe.cool/poker/evaluator.html
 * https://senzee.blogspot.com/2006/06/some-perfect-hash.html
 */
class Evaluator
{
    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function evaluateHand(array $hand): HandRank
    {
        return HandRank::evaluate(match (count($hand)) {
            5 => self::rankFiveCards(...$hand),
            7 => self::rankSevenCards($hand),
            default => throw new InvalidNumberOfCardsInHand($hand)
        });
    }

    /**
     * @param  array<int>  $hand
     *
     * @throws InvalidNumberOfCardsInHand
     */
    public static function rankHand(array $hand): int
    {
        return match (count($hand)) {
            5 => self::rankFiveCards(...$hand),
            7 => self::rankSevenCards($hand),
            default => throw new InvalidNumberOfCardsInHand($hand)
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
    public static function rankSevenCards(array $hand): int
    {
        $best = 9999;

        for ($i = 0; $i < 21; $i++) {
            $subhand = [];

            for ($j = 0; $j < 5; $j++) {
                $subhand[$j] = $hand[EvaluatorLookups::SEVEN_HAND_PERMUTATIONS[$i][$j]];
            }

            $q = self::rankHand($subhand);

            if ($q < $best) {
                $best = $q;
            }
        }

        return $best;
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
}
