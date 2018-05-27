<?php


namespace TicTacToe\Domain\Move\GridGameStateMove\ValueObject;

use Assert\Assertion;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\Move\ValueObject\Move;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;

abstract class GridGameStateMove extends Move
{
    /**
     * @param User $user
     * @param GridGameState $gameState
     * @param MoveParameters $moveParameters
     * @throws \Assert\AssertionFailedException
     */
    function make(User $user, GameState $gameState, MoveParameters $moveParameters)
    {
        Assertion::isInstanceOf($gameState, GridGameState::class,
            "Move can only be performed on Grid-based games");
    }
}
