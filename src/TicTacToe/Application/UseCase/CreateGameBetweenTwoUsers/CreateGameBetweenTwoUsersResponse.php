<?php


namespace TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers;


class CreateGameBetweenTwoUsersResponse
{
    private $gameId;

    public function __construct(
        string $gameId
    ) {
        $this->gameId = $gameId;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }
}
