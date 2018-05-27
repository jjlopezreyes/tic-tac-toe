<?php


namespace TicTacToe\Domain\Entity;

use TicTacToe\Domain\Entity\ValueObject\Identity;

interface Entity
{
    public function identity(): Identity;
}
