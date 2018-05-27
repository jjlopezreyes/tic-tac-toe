<?php

namespace TicTacToe\Application\UseCase\CreateUser;


class CreateUserResponse
{
    private $userId;

    public function __construct(
        string $userId
    ) {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}