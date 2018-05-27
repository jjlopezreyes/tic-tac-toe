<?php

namespace Tests\Unit\TicTacToe\Domain\Game\Entity;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use TicTacToe\Domain\Entity\ValueObject\Identity;
use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Domain\Game\MoveMade\Entity\MoveMade;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\Move\ValueObject\Move;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\WinCondition\ValueObject\WinCondition;

class GameTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldThrowExceptionIfUsersArrayIsEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Game(
            new Identity(Uuid::uuid4()->toString()),
            [],
            $this->buildGameState(),
            []
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfUsersArrayContainsNonUser()
    {
        $this->expectException(\InvalidArgumentException::class);
        $users = [
            $this->buildUser(),
            2
        ];

        new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $this->buildGameState(),
            []
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfWinConditionsArrayContainsNonWinCondition()
    {
        $this->expectException(\InvalidArgumentException::class);
        $users = [
            $this->buildUser()
        ];

        $winConditions = [
            1
        ];

        new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $this->buildGameState(),
            $winConditions
        );
    }

    /**
     * @test
     */
    public function itShouldConstructGame()
    {
        $users = [
            $this->buildUser()
        ];

        $winConditions = [
            $this->buildWinCondition()
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $this->buildGameState(),
            $winConditions
        );

        self::assertInstanceOf(Game::class, $game);
    }

    /**
     * @test
     */
    public function itShouldMakeMove()
    {
        $user = $this->buildUser();

        $users = [
            $user
        ];

        $initialState = $this->buildGameState();

        $winConditions = [
            $this->buildWinCondition()
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $initialState,
            $winConditions
        );

        $moveProphecy = $this->buildMoveProphecy();
        $moveParameters = $this->buildMoveParameters();

        $game->make($user, $moveProphecy->reveal(), $moveParameters);
        $moveProphecy->make($user, $initialState, $moveParameters)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfMoveIsMadeByUnregisteredUser()
    {
        $user = $this->buildUser();

        $users = [
            $this->buildUser()
        ];

        $initialState = $this->buildGameState();

        $winConditions = [
            $this->buildWinCondition()
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $initialState,
            $winConditions
        );

        $moveProphecy = $this->buildMoveProphecy();

        $this->expectException(\InvalidArgumentException::class);
        $game->make($user, $moveProphecy->reveal(), $this->buildMoveParameters());
    }

    /**
     * @test
     */
    public function itShouldRegisterMoveInMovesMade()
    {
        $user = $this->buildUser();

        $users = [
            $this->buildUser()
        ];

        $initialState = $this->buildGameState();

        $winConditions = [
            $this->buildWinCondition()
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $initialState,
            $winConditions
        );

        self::assertEmpty($game->getMovesMade());

        $moveProphecy = $this->buildMoveProphecy();
        $moveParameters = $this->buildMoveParameters();

        $this->expectException(\InvalidArgumentException::class);
        $game->make($user, $moveProphecy->reveal(), $moveParameters);
        $movesMade = $game->getMovesMade();
        self::assertEquals(1, count($movesMade));
        self::assertInstanceOf(MoveMade::class, array_pop($movesMade));
    }

    /**
     * @test
     */
    public function itShouldReturnWinnerIfAllWinConditionsReturnSameWinner()
    {
        $user = $this->buildUser();

        $users = [
            $user
        ];

        $trueWinConditions = [
            $this->buildWinCondition($user),
            $this->buildWinCondition($user),
            $this->buildWinCondition($user)
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $this->buildGameState(),
            $trueWinConditions
        );

        self::assertEquals($user, $game->checkWinConditions());
    }

    /**
     * @test
     */
    public function itShouldReturnNullIfWinConditionsDoNotReturnSameUser()
    {
        $firstUser = $this->buildUser();
        $secondUser = $this->buildUser();

        $users = [
            $firstUser,
            $secondUser
        ];

        $mixedWinConditions = [
            $this->buildWinCondition($firstUser),
            $this->buildWinCondition($secondUser),
            $this->buildWinCondition(null)
        ];

        $game = new Game(
            new Identity(Uuid::uuid4()->toString()),
            $users,
            $this->buildGameState(),
            $mixedWinConditions
        );

        self::assertNull($game->checkWinConditions());
    }

    public function buildUser()
    {
        return $this->prophesize(User::class)->reveal();
    }

    public function buildGameState()
    {
        return $this->prophesize(GameState::class)->reveal();
    }

    public function buildWinCondition(?User $checkReturnValue = null)
    {
        $prophecy = $this->prophesize(WinCondition::class);
        $prophecy->check(Argument::any())->willReturn($checkReturnValue);

        return $prophecy->reveal();
    }

    public function buildMoveProphecy()
    {
        return $this->prophesize(Move::class);
    }

    public function buildMoveParameters()
    {
        return $this->prophesize(MoveParameters::class)->reveal();
    }
}
