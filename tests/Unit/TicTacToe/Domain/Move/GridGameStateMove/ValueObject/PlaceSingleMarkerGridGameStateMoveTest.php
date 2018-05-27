<?php


namespace Tests\Unit\TicTacToe\Domain\Move\GridGameStateMove\ValueObject;


use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMove;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMoveParameters;
use TicTacToe\Domain\Move\ValueObject\MoveParameters;
use TicTacToe\Domain\User\Entity\User;

class PlaceSingleMarkerGridGameStateMoveTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldThrowExceptionIfIsNotPlaceSingleMarkerGridGameStateMoveParameters()
    {
        $this->expectException(\InvalidArgumentException::class);

        $move = new PlaceSingleMarkerGridGameStateMove();
        $move->make(
            $this->buildUser(),
            $this->buildGridGameState(),
            $this->buildMoveParameters()
        );
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfIsNotGridGameState()
    {
        $this->expectException(\InvalidArgumentException::class);

        $move = new PlaceSingleMarkerGridGameStateMove();
        $move->make(
            $this->buildUser(),
            $this->buildGameState(),
            $this->buildPlaceSingleMarkerGridGameStateMoveParameters()
        );
    }

    /**
     * @test
     */
    public function itShouldMakeMove()
    {
        $width = 3;
        $height = 5;
        $gameState = $this->buildGridGameStateProphecy();
        $user = $this->buildUser();

        $move = new PlaceSingleMarkerGridGameStateMove();
        $move->make(
            $user,
            $gameState->reveal(),
            $this->buildPlaceSingleMarkerGridGameStateMoveParameters(
                $width,
                $height
            )
        );

        $gameState->placeMark(
            $user,
            $width,
            $height
        )->shouldHaveBeenCalled();
    }

    private function buildUser()
    {
        return $this->prophesize(User::class)->reveal();
    }

    private function buildGameState()
    {
        return $this->prophesize(GameState::class)->reveal();
    }

    private function buildGridGameState()
    {
        return $this->buildGridGameStateProphecy()->reveal();
    }

    private function buildGridGameStateProphecy()
    {
        return $this->prophesize(GridGameState::class);
    }

    private function buildMoveParameters()
    {
        return $this->prophesize(MoveParameters::class)->reveal();
    }

    private function buildPlaceSingleMarkerGridGameStateMoveParameters(
        int $height = 0,
        int $width = 0
    ) {
        $prophecy = $this->prophesize(
            PlaceSingleMarkerGridGameStateMoveParameters::class
        );

        $prophecy->height()->willReturn($height);
        $prophecy->width()->willReturn($width);

        return $prophecy->reveal();
    }
}
