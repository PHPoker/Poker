<?php

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;
use Illuminate\Support\Str;

enum RaiseType: string
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case RFI = 'Raise First In';
    case ISO = 'Isolation Raise';
    case C_BET = 'Continuation Bet';
    case THREE_BET = '3-Bet';
    case FOUR_BET = '4-Bet';
    case FIVE_BET = '5-Bet';
    case SIX_BET = '6-Bet';
    case SEVEN_BET = '7-Bet';
    case SHOVE = 'All-In';
    case CHECK_RAISE = 'Check-Raise';

    public static function fromText(string $actionText): ?self
    {
        return match (Str::singular(strtoupper($actionText))) {
            'RFI' => self::RFI,
            'ISO' => self::ISO,
            'THREEBET', '3BET', '3 BET', 'THREE BET', '3-BET', '3_BET' => self::THREE_BET,
            'FOURBET', '4BET', '4 BET', 'FOUR BET', '4-BET', '4_BET' => self::FOUR_BET,
            'FIVEBET', '5BET', '5 BET', 'FIVE BET', '5-BET', '5_BET' => self::FIVE_BET,
            'SIXBET', '6BET', '6 BET', 'SIX BET', '6-BET', '6_BET' => self::SIX_BET,
            'SEVENBET', '7BET', '7 BET', 'SEVEN BET', '7-BET', '7_BET' => self::SEVEN_BET,
            'CBET', 'C-BET', 'C_BET', 'CONTINUATION BET', 'CONTINUATIONBET' => self::C_BET,
            'SHOVE', 'ALLIN', 'JAM', 'ALL-IN', 'ALL_IN' => self::SHOVE,
            'CHECKRAISE', 'CHECK-RAISE', 'CHECK_RAISE' => self::CHECK_RAISE,
            default => null,
        };
    }
}
