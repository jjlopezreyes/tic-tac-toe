<?php


namespace Tests\Component\TicTacToe\Application\UseCase\UserMakesMoveOnGame;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UseCase\UserMakesMoveOnGame\UserMakesMoveOnGameRequest;
use TicTacToe\Application\UseCase\UserMakesMoveOnGame\UserMakesMoveOnGameUseCase;
use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Infrastructure\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\MoveMade\Entity\MoveMade;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMove;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMoveParameters;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;
use TicTacToe\Domain\User\ValueObject\UserIdentity;
use TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject\ContinuousFullLengthLineWinCondition;

class UserMakesMoveOnGameUseCaseTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldMakeMove()
    {
        $user = new User(
            new UserIdentity()
        );

        $userRepository = new UserRepositoryInMemoryImpl();
        $userRepository->save($user);

        $game = new Game(
            new GameIdentity(),
            [$user],
            new GridGameState(
                3
            ),
            [new ContinuousFullLengthLineWinCondition()]
        );

        $gameRepository = new GameRepositoryInMemoryImpl();
        $gameRepository->save($game);

        $moveHeight = 2;
        $moveWidth = 1;

        $request = new UserMakesMoveOnGameRequest(
            $user->identity()->id(),
            $game->identity()->id(),
            $moveHeight,
            $moveWidth
        );

        $useCase = new UserMakesMoveOnGameUseCase(
            $userRepository,
            $gameRepository
        );

        self::assertEmpty($game->getMovesMade());

        $useCase->execute($request);

        $movesMade = $game->getMovesMade();
        self::assertEquals(1, count($movesMade));
        $moveMade = array_pop($movesMade);
        self::assertInstanceOf(MoveMade::class, $moveMade);
        self::assertSame($user, $moveMade->user());
        self::assertSame($game, $moveMade->game());
        self::assertInstanceOf(
            PlaceSingleMarkerGridGameStateMove::class,
            $moveMade->move()
        );
        /** @var PlaceSingleMarkerGridGameStateMoveParameters $moveParameters */
        $moveParameters = $moveMade->moveParameters();
        self::assertInstanceOf(
            PlaceSingleMarkerGridGameStateMoveParameters::class,
            $moveParameters
        );
        self::assertEquals($moveHeight, $moveParameters->height());
        self::assertEquals($moveWidth, $moveParameters->width());
    }
}
