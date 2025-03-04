<?php

namespace PHPoker\Poker\Exceptions;

class CannotDetermineCardSuit extends \Exception
{
    public function __construct(string|int $suitIdentifier, ?\Throwable $previousException = null)
    {
        $message = 'Cannot Determine Playing Card Suit From ['.$suitIdentifier.']';
        parent::__construct(message: $message, previous: $previousException);
    }
}
