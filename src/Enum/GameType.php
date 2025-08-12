<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

/**
 * Defines the type of poker game
 * Based on Open Hand History Specification
 *
 * @see https://hh-specs.handhistory.org/json-object/game_type
 */
enum GameType: string
{
    case HOLDEM = 'Holdem';
    case OMAHA = 'Omaha';
    case OMAHA_HILO = 'OmahaHiLo';
    case STUD = 'Stud';
    case STUD_HILO = 'StudHiLo';
    case DRAW = 'Draw';

    public static function fromText(?string $gameType): ?self
    {
        if (! $gameType) {
            return null;
        }

        return match (strtolower(str_replace([' ', '-', "'"], '', $gameType))) {
            'holdem', 'texasholdem', 'nlh', 'nlhe' => self::HOLDEM,
            'omaha', 'plo' => self::OMAHA,
            'omahahilo', 'omahahighlow' => self::OMAHA_HILO,
            'stud', '5cardstud', '7cardstud', 'fivecardstud','sevencardstud' => self::STUD,
            'studhilo', 'studhighlow', 'studhighlo', 'studhilow', '5cardstudhilo', '7cardstudhilo', 'fivecardstudhilo','sevencardstudhighlow' => self::STUD_HILO,
            'draw', '5carddraw', '7carddraw', 'fivecarddraw','sevencarddraw', '27tripledraw', '27triple', 'twoseventriple' => self::DRAW,
            default => null
        };
    }
}
