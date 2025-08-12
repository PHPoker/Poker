<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum HandRank: int
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case STRAIGHT_FLUSH = 1;
    case FOUR_OF_A_KIND = 2;
    case FULL_HOUSE = 3;
    case FLUSH = 4;
    case STRAIGHT = 5;
    case THREE_OF_A_KIND = 6;
    case TWO_PAIR = 7;
    case ONE_PAIR = 8;
    case HIGH_CARD = 9;

    private const MAX_VALUE_HIGH_CARD = 6185;

    private const MAX_VALUE_ONE_PAIR = 3325;

    private const MAX_VALUE_TWO_PAIR = 2467;

    private const MAX_VALUE_THREE_OF_A_KIND = 1609;

    private const MAX_VALUE_STRAIGHT = 1599;

    private const MAX_VALUE_FLUSH = 322;

    private const MAX_VALUE_FULL_HOUSE = 166;

    private const MAX_VALUE_FOUR_OF_A_KIND = 10;

    public static function evaluate(int $handValue): self
    {
        return match (true) {
            $handValue > self::MAX_VALUE_HIGH_CARD => self::HIGH_CARD,
            $handValue > self::MAX_VALUE_ONE_PAIR => self::ONE_PAIR,
            $handValue > self::MAX_VALUE_TWO_PAIR => self::TWO_PAIR,
            $handValue > self::MAX_VALUE_THREE_OF_A_KIND => self::THREE_OF_A_KIND,
            $handValue > self::MAX_VALUE_STRAIGHT => self::STRAIGHT,
            $handValue > self::MAX_VALUE_FLUSH => self::FLUSH,
            $handValue > self::MAX_VALUE_FULL_HOUSE => self::FULL_HOUSE,
            $handValue > self::MAX_VALUE_FOUR_OF_A_KIND => self::FOUR_OF_A_KIND,
            default => self::STRAIGHT_FLUSH,
        };
    }
}
