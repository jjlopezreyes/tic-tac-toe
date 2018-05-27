<?php


namespace TicTacToe\Domain\Entity\ValueObject;

use Assertion\Assertion;
use Ramsey\Uuid\Uuid;

class Identity
{
    private $id;

    /**
     * Identity constructor.
     * @param string $id
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(
        string $id = null
    ) {
        if($id != null) {
            Assertion::uuid($id);
        } else {
            $id = Uuid::uuid4()->toString();
        }


        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
