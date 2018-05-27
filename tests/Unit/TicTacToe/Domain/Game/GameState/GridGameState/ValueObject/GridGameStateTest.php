<?php


namespace Tests\Unit\TicTacToe\Domain\Game\GameState\GridGameState\ValueObject;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\User\Entity\User;

class GridGameStateTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldThrowExceptionIfHeightOutOfBounds()
    {
        $size = 9;

        $markHeight = 9;
        $markWidth = 5;

        $gameState = new GridGameState(
            $size
        );

        $this->expectException(\InvalidArgumentException::class);
        $gameState->placeMark(
            $this->buildUser(),
            $markHeight,
            $markWidth
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfWidthOutOfBounds()
    {
        $size = 10;

        $markHeight = 4;
        $markWidth = 10;

        $gameState = new GridGameState(
            $size
        );

        $this->expectException(\InvalidArgumentException::class);
        $gameState->placeMark(
            $this->buildUser(),
            $markHeight,
            $markWidth
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfPositionAlreadyMarked()
    {
        $size = 11;

        $markHeight = 4;
        $markWidth = 10;

        $gameState = new GridGameState(
            $size
        );

        $gameState->placeMark(
            $this->buildUser(),
            $markHeight,
            $markWidth
        );

        $this->expectException(\InvalidArgumentException::class);
        $gameState->placeMark(
            $this->buildUser(),
            $markHeight,
            $markWidth
        );
    }

    /**
     * @test
     */
    public function itShouldPlaceMark()
    {
        $size = 10;

        $markHeight = 9;
        $markWidth = 5;

        $user = $this->buildUser();

        $gameState = new GridGameState(
            $size
        );

        $gameState->placeMark(
            $user,
            $markHeight,
            $markWidth
        );

        $markRows = $gameState->markRows();

        self::assertEquals($user, $markRows[$markHeight][$markWidth]);
    }

    private function buildUser()
    {
        return $this->prophesize(User::class)->reveal();
    }
}
