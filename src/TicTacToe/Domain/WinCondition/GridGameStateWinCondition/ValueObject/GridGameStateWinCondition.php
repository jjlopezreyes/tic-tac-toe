<?php


namespace TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject;


use Assertion\Assertion;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\WinCondition\ValueObject\WinCondition;

abstract class GridGameStateWinCondition implements WinCondition
{
    public function check(
        GameState $gameState
    ): ?User
    {
        Assertion::isInstanceOf($gameState, GridGameState::class);

        return null;
    }
}
