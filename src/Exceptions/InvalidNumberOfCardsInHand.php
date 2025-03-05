<?php

namespace PHPoker\Poker\Exceptions;

use PHPoker\Poker\Collections\CardCollection;

class InvalidNumberOfCardsInHand extends \Exception
{
    /** @var int[] */
    protected array $hand;

    /**
     * @param  int[]  $hand
     */
    public function __construct(array $hand, ?\Exception $previousException = null)
    {
        $this->hand = $hand;
        $message = 'Invalid Number Of Cards In Hand -- only 5 or 7 supported!';
        parent::__construct(message: $message, previous: $previousException);
    }

    public function hand(): CardCollection
    {
        return CardCollection::fromIntegers($this->hand);
    }
}
