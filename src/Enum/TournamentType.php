<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

/**
 * Enum representing the type of poker tournament
 *
 * @see https://hh-specs.handhistory.org/tournament-info-object/tournament_info_obj/type
 */
enum TournamentType: string
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;
    case MULTI_TABLE_TOURNAMENT = 'MTT';
    case SINGLE_TABLE_TOURNAMENT = 'STT';
}
