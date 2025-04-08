<?php

namespace PHPoker\Poker\Enum;

enum RangeComboType
{
    case PAIR;
    case SUITED;
    case OFFSUIT;

    public const COMBO_COUNT_SUITED = 4;
    public const COMBO_COUNT_PAIR = 6;
    public const COMBO_COUNT_OFFSUIT = 12;

    public function notation(): string
    {
        return match($this) {
            self::PAIR => '',
            self::SUITED => 's',
            self::OFFSUIT => 'o',
        };
    }

    public static function fromNotation(?string $notation): self
    {
        return match(strtolower($notation ?? '')) {
            's' => self::SUITED,
            'o' => self::OFFSUIT,
            '' => self::PAIR,
            default => throw new \InvalidArgumentException("Invalid range combo type: {$notation}")
        };
    }
    public function comboCount(): int
    {
        return match($this) {
            self::PAIR => self::COMBO_COUNT_PAIR,
            self::SUITED => self::COMBO_COUNT_SUITED,
            self::OFFSUIT => self::COMBO_COUNT_OFFSUIT,
        };
    }
}
