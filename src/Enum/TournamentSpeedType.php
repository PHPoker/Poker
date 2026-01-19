<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

/**
 * Enum representing the speed at which the blinds increase in a poker game.
 *
 * @see https://hh-specs.handhistory.org/speed-object/speed_obj/type
 */
enum TournamentSpeedType: string
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case NORMAL = 'Normal'; // Standard game speed

    case SEMI_TURBO = 'Semi-Turbo'; // Moderately fast game speed

    case TURBO = 'Turbo'; // Fast game speed

    case SUPER_TURBO = 'Super-Turbo'; // Very fast game speed

    case HYPER_TURBO = 'Hyper-Turbo'; // Extremely fast game speed

    case ULTRA_TURBO = 'Ultra-Turbo'; // Ultimate game speed
}
