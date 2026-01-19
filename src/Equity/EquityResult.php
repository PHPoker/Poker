<?php

declare(strict_types=1);

namespace PHPoker\Poker\Equity;

use PHPoker\Poker\Collections\CardCollection;

final readonly class EquityResult
{
    /**
     * @param  array<EquityCalculation>  $equities
     */
    public function __construct(
        public array $equities,
        public int $iterations,
        public CardCollection $board,
        public CardCollection $deadCards,
    ) {}

    public function playerCount(): int
    {
        return count($this->equities);
    }
}
