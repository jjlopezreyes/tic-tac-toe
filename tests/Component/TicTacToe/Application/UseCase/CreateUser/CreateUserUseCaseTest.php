<?php


namespace Tests\Component\TicTacToe\Application\UseCase\CreateUser;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UseCase\CreateUser\CreateUserRequest;
use TicTacToe\Application\UseCase\CreateUser\CreateUserUseCase;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;

class CreateUserUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateUser()
    {
        $request = new CreateUserRequest();

        $userRepository = new UserRepositoryInMemoryImpl();
        self::assertEmpty($userRepository->getAll());

        $useCase = new CreateUserUseCase(
            $userRepository
        );

        $useCase->execute($request);

        $allUsers = $userRepository->getAll();
        self::assertEquals(1, count($allUsers));
        self::assertInstanceOf(User::class, array_pop($allUsers));
    }
}
