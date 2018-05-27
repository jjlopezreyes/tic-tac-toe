<?php


namespace TicTacToe\Application\UseCase\CheckGameWinner;


use TicTacToe\Domain\User\Entity\User;

class CheckGameWinnerResponse
{
    private $winner;

    public function __construct(
        ?User $winner
    ) {
        $this->winner = $winner;
    }

    public function winner()
    {
        return $this->winner;
    }
}
