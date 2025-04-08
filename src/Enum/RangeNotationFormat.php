<?php

namespace PHPoker\Poker\Enum;

enum RangeNotationFormat
{
    case DEFAULT;
    case PIO;
    case SIMPLE;

    public function formatString(): string
    {
        return match ($this) {
            self::DEFAULT => 'FFS{W}',
            self::PIO => 'FFS w',
            self::SIMPLE => 'FFS',
        };
    }
}
