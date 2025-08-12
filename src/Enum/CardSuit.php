<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;
use PHPoker\Poker\Exceptions\CannotDetermineCardSuit;

enum CardSuit: int
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case CLUB = 0x8000;

    case DIAMOND = 0x4000;

    case HEART = 0x2000;

    case SPADE = 0x1000;

    public const CLUB_BIT_MASK_VALUE = 8;

    public const DIAMOND_BIT_MASK_VALUE = 4;

    public const HEART_BIT_MASK_VALUE = 2;

    public const SPADE_BIT_MASK_VALUE = 1;

    /**
     * @throws CannotDetermineCardSuit
     */
    public static function fromText(string $suitString): self
    {
        return match (strtolower($suitString)) {
            '♣', 'c', 'club', 'clubs' => self::CLUB,
            '♦', 'd', 'diamond', 'diamonds' => self::DIAMOND,
            '♥', 'h', 'heart', 'hearts' => self::HEART,
            '♠', 's', 'spade', 'spades' => self::SPADE,
            default => throw new CannotDetermineCardSuit(suitIdentifier: $suitString)
        };
    }

    /**
     * @throws CannotDetermineCardSuit
     */
    public static function fromInteger(int $suitValue): self
    {
        try {
            return self::from($suitValue);
        } catch (\ValueError $e) {
            throw new CannotDetermineCardSuit(suitIdentifier: $suitValue, previousException: $e);
        }
    }

    /**
     * @throws CannotDetermineCardSuit
     */
    public static function fromCardInteger(int $cardValue): self
    {
        return match (($cardValue >> 12) & 0xF) {
            8 => self::CLUB,
            4 => self::DIAMOND,
            2 => self::HEART,
            1 => self::SPADE,
            default => throw new CannotDetermineCardSuit(suitIdentifier: $cardValue)
        };
    }

    public function bitMask(): string
    {
        $bitMaskValue = match ($this) {
            self::CLUB => self::CLUB_BIT_MASK_VALUE,
            self::DIAMOND => self::DIAMOND_BIT_MASK_VALUE,
            self::HEART => self::HEART_BIT_MASK_VALUE,
            self::SPADE => self::SPADE_BIT_MASK_VALUE,
        };

        return sprintf('%04d', decbin($bitMaskValue));
    }

    public function symbol(): string
    {
        return match ($this) {
            self::CLUB => '♣',
            self::DIAMOND => '♦',
            self::HEART => '♥',
            self::SPADE => '♠',
        };
    }

    public function text(): string
    {
        return match ($this) {
            self::CLUB => 'c',
            self::DIAMOND => 'd',
            self::HEART => 'h',
            self::SPADE => 's',
        };
    }

    /**
     * @return static
     */
    public static function random(): self
    {
        return self::cases()[array_rand(self::cases(), 1)];
    }
}
