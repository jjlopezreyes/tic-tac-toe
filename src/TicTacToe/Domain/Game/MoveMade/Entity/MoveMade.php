<?php


namespace TicTacToe\Domain\Game\MoveMade\Entity;

use TicTacToe\Domain\Entity\BaseEntity;
use TicTacToe\Domain\Entity\ValueObject\Identity;
use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Domain\Game\MoveMade\Entity\ValueObject\MoveMadeIdentity;
use TicTacToe\Domain\Move\ValueObject\Move;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;

class MoveMade extends BaseEntity
{
    protected const IDENTITY_CLASS = MoveMadeIdentity::class;
    private $game;
    private $user;
    private $move;
    private $moveParameters;

    public function __construct(
        Identity $identity,
        Game $game,
        User $user,
        Move $move,
        MoveParameters $moveParameters
    ) {
        parent::__construct($identity);
        $this->game = $game;
        $this->user = $user;
        $this->move = $move;
        $this->moveParameters = $moveParameters;
    }

    public function game(): Game
    {
        return $this->game;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function move(): Move
    {
        return $this->move;
    }

    public function moveParameters(): MoveParameters
    {
        return $this->moveParameters;
    }
}
