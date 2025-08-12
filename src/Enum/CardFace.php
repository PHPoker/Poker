<?php

declare(strict_types=1);

namespace PHPoker\Poker\Enum;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;
use PHPoker\Poker\Exceptions\CannotDetermineCardFace;

enum CardFace: int
{
    use InvokableCases;
    use Names;
    use Options;
    use Values;

    case TWO = 0;

    case THREE = 1;

    case FOUR = 2;

    case FIVE = 3;

    case SIX = 4;

    case SEVEN = 5;

    case EIGHT = 6;

    case NINE = 7;

    case TEN = 8;

    case JACK = 9;

    case QUEEN = 10;

    case KING = 11;

    case ACE = 12;

    /**
     * @throws CannotDetermineCardFace
     */
    public static function fromText(string $faceString): self
    {
        return match (strtolower($faceString)) {
            '2', 'two' => self::TWO,
            '3', 'three' => self::THREE,
            '4', 'four' => self::FOUR,
            '5', 'five' => self::FIVE,
            '6', 'six' => self::SIX,
            '7', 'seven' => self::SEVEN,
            '8', 'eight' => self::EIGHT,
            '9', 'nine' => self::NINE,
            '10', 't', 'ten' => self::TEN,
            'j', 'jack' => self::JACK,
            'q', 'queen' => self::QUEEN,
            'k', 'king' => self::KING,
            'a', 'ace' => self::ACE,
            default => throw new CannotDetermineCardFace($faceString)
        };
    }

    /**
     * @throws CannotDetermineCardFace
     */
    public static function fromInteger(int $faceValue): self
    {
        try {
            return self::from($faceValue);
        } catch (\Error $e) {
            throw new CannotDetermineCardFace($faceValue);
        }
    }

    /**
     * @throws CannotDetermineCardFace
     */
    public static function fromCardInteger(int $cardValue): self
    {
        return self::fromInteger(($cardValue >> 8) & 0xF);
    }

    /**
     * @return string[]
     */
    public static function symbols(): array
    {
        return ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    }

    public function prime(): int
    {
        return match ($this) {
            self::TWO => 2,
            self::THREE => 3,
            self::FOUR => 5,
            self::FIVE => 7,
            self::SIX => 11,
            self::SEVEN => 13,
            self::EIGHT => 17,
            self::NINE => 19,
            self::TEN => 23,
            self::JACK => 29,
            self::QUEEN => 31,
            self::KING => 37,
            self::ACE => 41,
        };
    }

    public function primeBitMask(): string
    {
        return sprintf('%08d', decbin($this->prime()));
    }

    public function maskValue(): int
    {
        return 2 ** $this->value;
    }

    public function valueBitMask(): string
    {
        return sprintf('%016d', decbin($this->maskValue()));
    }

    public function rankBitMask(): string
    {
        return sprintf('%04d', decbin($this->value));
    }

    public function symbol(): string
    {
        return match ($this) {
            self::TWO => '2',
            self::THREE => '3',
            self::FOUR => '4',
            self::FIVE => '5',
            self::SIX => '6',
            self::SEVEN => '7',
            self::EIGHT => '8',
            self::NINE => '9',
            self::TEN => 'T',
            self::JACK => 'J',
            self::QUEEN => 'Q',
            self::KING => 'K',
            self::ACE => 'A',
        };
    }

    public function faceValue(bool $low = false): int
    {
        return match ($this) {
            self::TWO => 2,
            self::THREE => 3,
            self::FOUR => 4,
            self::FIVE => 5,
            self::SIX => 6,
            self::SEVEN => 7,
            self::EIGHT => 8,
            self::NINE => 9,
            self::TEN => 10,
            self::JACK => 11,
            self::QUEEN => 12,
            self::KING => 13,
            self::ACE => $low ? 1 : 14,
        };
    }

    public function plus(int $howMany): self
    {
        $currentFaceIndex = array_search($this->symbol(), self::symbols(), true);

        if ($currentFaceIndex === false) {
            throw new \RuntimeException("Symbol {$this->symbol()} not found in symbols array");
        }

        $newFaceIndex = ((int) $currentFaceIndex + $howMany) % count(self::symbols());

        return self::fromText(self::symbols()[$newFaceIndex]);
    }
}
