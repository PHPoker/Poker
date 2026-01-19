<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

/**
 * Defines the type of poker game betting structure
 * Based on Open Hand History Specification
 *
 * @see https://hh-specs.handhistory.org/bet-limit-object/bet_limit_obj/bet_type
 */
enum BetLimitType: string
{
    case NO_LIMIT = 'NL';       // Players can bet any amount of their chips, up to all of their remaining chips.

    case POT_LIMIT = 'PL';      // Players can bet up to the total size of the current pot.

    case FIXED_LIMIT = 'FL';    // Players must follow specific bet sizes and raise amounts, typically set in advance for each round of betting.

    public static function fromText(?string $betLimitType): ?self
    {
        if (! $betLimitType) {
            return null;
        }

        return match (strtolower(str_replace([' ', '-', '_', "'"], '', $betLimitType))) {
            'nolimit', 'nl' => self::NO_LIMIT,
            'potlimit', 'pl', 'pot' => self::POT_LIMIT,
            'fixedlimit', 'fl', 'fixed' => self::FIXED_LIMIT,
            default => null
        };
    }
}
