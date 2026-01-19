<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

/**
 * Enum representing descriptive properties of Poker Tournaments
 *
 * @see https://hh-specs.handhistory.org/tournament-info-object/tournament_info_obj/flags
 */
enum TournamentProperties: string
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case SNG = 'SNG';   // Sit 'N Go

    case DON = 'DON';   // Double or nothing

    case BOUNTY = 'Bounty';    // Players are awarded prizes for knocking out specific players

    case SHOOTOUT = 'Shootout';   // A multi-table tournament played in stages

    case REBUY = 'Rebuy';   // Players are offered the opportunity to rebuy stacks of chips

    case MATRIX = 'Matrix';   // One buyin is split between multiple games

    case PUSH_OR_FOLD = 'Push_Or_Fold';   // Required to fold or push all-in every hand

    case SATELLITE = 'Satellite';   // Prize includes entry into another tournament

    case STEPS = 'Steps';   // Incremental seats to additional tournaments

    case DEEP = 'Deep';   // Deep stack tournament

    case MULTI_ENTRY = 'Multi-Entry';   // Players can have more than a single entry

    case FIFTY50 = 'Fifty50';   // Fifty percent of players win a prize

    case FLIPOUT = 'Flipout';   // Hands played face up without betting rounds

    case TRIPLEUP = 'TripleUp';   // A third of the players win three times their buy-in

    case LOTTERY = 'Lottery';   // Fast action games with randomly chosen prize

    case RE_ENTRY = 'Re-Entry';   // A player can re-enter after being felted

    case POWER_UP = 'Power_Up';   // Game with special "powers"

    case PROGRESSIVE_BOUNTY = 'Progressive-Bounty';   // Bounty amount varies, with part added to the winner's bounty
}
