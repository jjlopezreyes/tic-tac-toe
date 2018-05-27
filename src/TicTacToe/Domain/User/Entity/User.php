<?php

namespace TicTacToe\Domain\User\Entity;


use TicTacToe\Domain\Entity\Entity;
use TicTacToe\Domain\Entity\ValueObject\Identity;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class User implements Entity
{
    private $identity;

    public function __construct(
        UserIdentity $identity
    ) {
        $this->identity = $identity;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
