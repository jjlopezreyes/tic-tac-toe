<?php


namespace TicTacToe\Domain\WinCondition\ValueObject;

use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\User\Entity\User;

interface WinCondition
{
    public function check(
        GameState $gameState
    ): ?User;
}
