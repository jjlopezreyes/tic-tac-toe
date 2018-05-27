<?php


namespace Tests\Component\TicTacToe\Application\UseCase\CheckGameWinner;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UseCase\CheckGameWinner\CheckGameWinnerRequest;
use TicTacToe\Application\UseCase\CheckGameWinner\CheckGameWinnerResponse;
use TicTacToe\Application\UseCase\CheckGameWinner\CheckGameWinnerUseCase;
use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Infrastructure\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\User\ValueObject\UserIdentity;
use TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject\ContinuousFullLengthLineWinCondition;

class CheckGameWinnerUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCheckWinnerFirstUser()
    {
        $firstUser = new User(
            new UserIdentity()
        );

        $secondUser = new User(
            new UserIdentity()
        );

        $gameState = new GridGameState(3);
        $gameState->placeMark($firstUser, 0, 0);
        $gameState->placeMark($firstUser, 1, 0);
        $gameState->placeMark($firstUser, 2, 0);
        $gameState->placeMark($secondUser, 0, 1);
        $gameState->placeMark($secondUser, 0, 2);

        $game = new Game(
            new GameIdentity(),
            [
                $firstUser,
                $secondUser
            ],
            $gameState,
            [new ContinuousFullLengthLineWinCondition()]
        );

        $gameRepository = new GameRepositoryInMemoryImpl();
        $gameRepository->save($game);

        $request = new CheckGameWinnerRequest(
            $game->identity()->id()
        );

        $useCase = new CheckGameWinnerUseCase(
            $gameRepository
        );

        $response = $useCase->execute($request);
        self::assertInstanceOf(CheckGameWinnerResponse::class, $response);
        $winner = $response->winner();
        self::assertSame($firstUser, $winner);
    }

    /**
     * @test
     */
    public function itShouldCheckWinnerSecondUser()
    {
        $firstUser = new User(
            new UserIdentity()
        );

        $secondUser = new User(
            new UserIdentity()
        );

        $gameState = new GridGameState(3);
        $gameState->placeMark($firstUser, 0, 0);
        $gameState->placeMark($firstUser, 1, 0);
        $gameState->placeMark($firstUser, 0, 1);
        $gameState->placeMark($secondUser, 0, 2);
        $gameState->placeMark($secondUser, 1, 1);
        $gameState->placeMark($secondUser, 2, 0);

        $game = new Game(
            new GameIdentity(),
            [
                $firstUser,
                $secondUser
            ],
            $gameState,
            [new ContinuousFullLengthLineWinCondition()]
        );

        $gameRepository = new GameRepositoryInMemoryImpl();
        $gameRepository->save($game);

        $request = new CheckGameWinnerRequest(
            $game->identity()->id()
        );

        $useCase = new CheckGameWinnerUseCase(
            $gameRepository
        );

        $response = $useCase->execute($request);
        self::assertInstanceOf(CheckGameWinnerResponse::class, $response);
        $winner = $response->winner();
        self::assertSame($secondUser, $winner);
    }

    /**
     * @test
     */
    public function itShouldCheckNoWinner()
    {
        $firstUser = new User(
            new UserIdentity()
        );

        $secondUser = new User(
            new UserIdentity()
        );

        $gameState = new GridGameState(3);
        $gameState->placeMark($firstUser, 0, 0);
        $gameState->placeMark($firstUser, 1, 0);
        $gameState->placeMark($firstUser, 0, 1);
        $gameState->placeMark($secondUser, 0, 2);
        $gameState->placeMark($secondUser, 1, 1);
        $gameState->placeMark($secondUser, 2, 2);

        $game = new Game(
            new GameIdentity(),
            [
                $firstUser,
                $secondUser
            ],
            $gameState,
            [new ContinuousFullLengthLineWinCondition()]
        );

        $gameRepository = new GameRepositoryInMemoryImpl();
        $gameRepository->save($game);

        $request = new CheckGameWinnerRequest(
            $game->identity()->id()
        );

        $useCase = new CheckGameWinnerUseCase(
            $gameRepository
        );

        $response = $useCase->execute($request);
        self::assertInstanceOf(CheckGameWinnerResponse::class, $response);
        $winner = $response->winner();
        self::assertNull($winner);
    }
}
