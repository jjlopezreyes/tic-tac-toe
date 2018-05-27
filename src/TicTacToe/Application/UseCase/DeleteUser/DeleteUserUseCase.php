<?php


namespace TicTacToe\Application\UseCase\DeleteUser;

use TicTacToe\Domain\User\Entity\Repository\UserRepository;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class DeleteUserUseCase
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteUserRequest $request)
    {
        $userIdentity = new UserIdentity($request->userId());
        $user = $this->userRepository->get($userIdentity);

        $this->userRepository->delete($user);

        return new DeleteUserResponse();
    }
}
