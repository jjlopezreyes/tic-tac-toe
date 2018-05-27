<?php


namespace TicTacToe\Application\UseCase\UserMakesMoveOnGame;


class UserMakesMoveOnGameRequest
{
    private $userId;
    private $gameId;
    private $height;
    private $width;

    public function __construct(
        string $userId,
        string $gameId,
        int $height,
        int $width
    ) {
        $this->userId = $userId;
        $this->gameId = $gameId;
        $this->height = $height;
        $this->width = $width;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function width(): int
    {
        return $this->width;
    }
}
