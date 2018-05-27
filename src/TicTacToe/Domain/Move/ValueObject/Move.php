<?php


namespace TicTacToe\Domain\Move\ValueObject;

use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\User\Entity\User;

abstract class Move
{
    abstract function make(
        User $user,
        GameState $gameState,
        MoveParameters $moveParameters
    );
}
