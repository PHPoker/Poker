<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

/**
 * Enum representing various properties of a poker hand
 *
 * @see https://hh-specs.handhistory.org/json-object/flags
 */
enum HandProperties: string
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case RUN_IT_TWICE = 'Run_It_Twice';   // Two or more sets of board cards are used in the play of the same hand

    case ANONYMOUS = 'Anonymous';    // The players at the table are all anonymous

    case OBSERVED = 'Observed';   // The hand was observed and the hero was not dealt into the hand

    case FAST = 'Fast';   // Any fast fold variant where once you fold you immediately move to the next hand

    case CAP = 'Cap';   // A game that limits the amount that each player can wager per hand
}
