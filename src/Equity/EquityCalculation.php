<?php

declare(strict_types=1);

namespace PHPoker\Poker\Equity;

final readonly class EquityCalculation implements \JsonSerializable
{
    public function __construct(
        public string $hand,
        public float $equity,
        public int $wins,
        public int $ties,
        public int $iterations,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'hand' => $this->hand,
            'equity' => $this->equity,
            'wins' => $this->wins,
            'ties' => $this->ties,
            'iterations' => $this->iterations,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
