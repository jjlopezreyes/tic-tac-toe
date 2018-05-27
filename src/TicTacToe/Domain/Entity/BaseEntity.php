<?php


namespace TicTacToe\Domain\Entity;

use Assertion\Assertion;
use TicTacToe\Domain\Entity\ValueObject\Identity;

class BaseEntity implements Entity
{
    protected const IDENTITY_CLASS = Identity::class;
    protected $identity;

    public function __construct(
        Identity $identity
    ) {
        Assertion::isInstanceOf(
            $identity,
            static::IDENTITY_CLASS,
            "Entity only accepts Identity of type ".static::IDENTITY_CLASS
        );
        $this->identity = $identity;
    }

    public function identity(): Identity
    {
        return $this->identity;
    }
}
