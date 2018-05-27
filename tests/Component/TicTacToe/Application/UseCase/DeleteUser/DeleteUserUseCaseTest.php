<?php


namespace Tests\Component\TicTacToe\Application\UseCase\DeleteUser;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UseCase\DeleteUser\DeleteUserRequest;
use TicTacToe\Application\UseCase\DeleteUser\DeleteUserUseCase;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class DeleteUserUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldDeleteUser()
    {
        $userIdentity = new UserIdentity();
        $user = new User(
            $userIdentity
        );

        $repository = new UserRepositoryInMemoryImpl();
        $repository->save($user);

        $allUsers = $repository->getAll();
        self::assertContains($user, $allUsers);

        $request = new DeleteUserRequest(
            $userIdentity->id()
        );

        $useCase = new DeleteUserUseCase(
            $repository
        );

        $useCase->execute($request);

        $allUsers = $repository->getAll();
        self::assertEmpty($allUsers);
    }
}
