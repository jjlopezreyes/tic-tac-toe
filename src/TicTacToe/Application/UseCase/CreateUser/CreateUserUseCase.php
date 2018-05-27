<?php

namespace TicTacToe\Application\UseCase\CreateUser;

use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\User\Entity\Repository\UserRepository;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class CreateUserUseCase
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserRequest $request): CreateUserResponse
    {
        $user = new User(
            new UserIdentity()
        );

        $this->userRepository->save($user);

        return new CreateUserResponse(
            $user->identity()->id()
        );
    }
}
