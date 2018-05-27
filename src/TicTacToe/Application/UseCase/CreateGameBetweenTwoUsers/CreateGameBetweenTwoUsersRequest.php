<?php


namespace TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers;


class CreateGameBetweenTwoUsersRequest
{
    private $firstUserId;
    private $secondUserId;
    private $gridSize;

    public function __construct(
        string $firstUserId,
        string $secondUserId,
        int $gridSize
    ) {
        $this->firstUserId = $firstUserId;
        $this->secondUserId = $secondUserId;
        $this->gridSize = $gridSize;
    }

    public function firstUserId(): string
    {
        return $this->firstUserId;
    }

    public function secondUserId(): string
    {
        return $this->secondUserId;
    }

    public function gridSize(): int
    {
        return $this->gridSize;
    }
}
