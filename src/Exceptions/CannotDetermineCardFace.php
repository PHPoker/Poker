<?php

namespace PHPoker\Poker\Exceptions;

class CannotDetermineCardFace extends \Exception
{
    public function __construct(string|int $cardFaceIdentifier, ?\Exception $previousException = null)
    {
        $message = 'Cannot Determine Playing Card Face From ['.$cardFaceIdentifier.']';
        parent::__construct(message: $message, previous: $previousException);
    }
}
