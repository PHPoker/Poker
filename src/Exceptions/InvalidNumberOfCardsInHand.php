<?php

declare(strict_types=1);

namespace PHPoker\Poker\Exceptions;

use PHPoker\Poker\Collections\CardCollection;

class InvalidNumberOfCardsInHand extends \Exception
{
    /**
     * @param  int[]  $hand
     */
    public function __construct(protected array $hand, ?\Exception $previousException = null)
    {
        $message = 'Invalid Number Of Cards In Hand -- only 5 or 7 supported!';
        parent::__construct(message: $message, previous: $previousException);
    }

    public function hand(): CardCollection
    {
        return CardCollection::fromIntegers($this->hand);
    }
}
