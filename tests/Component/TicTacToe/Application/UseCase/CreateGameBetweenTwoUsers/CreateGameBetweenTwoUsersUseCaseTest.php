<?php


namespace Tests\Component\TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers\CreateGameBetweenTwoUsersRequest;
use TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers\CreateGameBetweenTwoUsersUseCase;
use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Infrastructure\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class CreateGameBetweenTwoUsersUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateGame()
    {
        $firstUser = new User(
            new UserIdentity()
        );

        $secondUser = new User(
            new UserIdentity()
        );

        $size = 3;

        $userRepository = new UserRepositoryInMemoryImpl();
        $userRepository->save($firstUser);
        $userRepository->save($secondUser);

        $gameRepository = new GameRepositoryInMemoryImpl();

        $allGames = $gameRepository->getAll();
        self::assertEmpty($allGames);

        $request = new CreateGameBetweenTwoUsersRequest(
            $firstUser->identity()->id(),
            $secondUser->identity()->id(),
            $size
        );

        $useCase = new CreateGameBetweenTwoUsersUseCase(
            $userRepository,
            $gameRepository
        );

        $useCase->execute($request);

        $allGames = $gameRepository->getAll();
        self::assertEquals(1, count($allGames));
        self::assertInstanceOf(Game::class, array_pop($allGames));
    }
}
