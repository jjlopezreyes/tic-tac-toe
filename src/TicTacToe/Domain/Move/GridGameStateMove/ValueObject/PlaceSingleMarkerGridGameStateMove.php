<?php


namespace TicTacToe\Domain\Move\GridGameStateMove\ValueObject;

use Assertion\Assertion;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;

class PlaceSingleMarkerGridGameStateMove extends GridGameStateMove
{
    /**
     * @param User $user
     * @param GridGameState $gameState
     * @param PlaceSingleMarkerGridGameStateMoveParameters $moveParameters
     * @throws \Assert\AssertionFailedException
     */
    public function make(User $user, GameState $gameState, MoveParameters $moveParameters)
    {
        parent::make($user, $gameState, $moveParameters);

        Assertion::isInstanceOf($moveParameters,
            PlaceSingleMarkerGridGameStateMoveParameters::class,
            "Move requires valid parameters"
        );
        $gameState->placeMark(
            $user,
            $moveParameters->height(),
            $moveParameters->width()
        );
    }
}
