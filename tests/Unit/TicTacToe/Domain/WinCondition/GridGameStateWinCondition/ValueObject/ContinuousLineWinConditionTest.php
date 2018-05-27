<?php


namespace Tests\Unit\TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject;


use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject\ContinuousFullLengthLineWinCondition;

class ContinuousLineWinConditionTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnNullIfNoLinesFullOfSamePlayerMarks()
    {
        $winCondition = new ContinuousFullLengthLineWinCondition();
        self::assertNull(
            $winCondition->check(
                $this->buildGameState()
            )
        );
    }

    /**
     * @test
     */
    public function itShouldReturnUserIfRowFullOfSamePlayerMarks()
    {
        $user = $this->buildUser();

        $size = 3;
        $markRows = [
            [null, null, null],
            [$user, $user, $user],
            [null, null, null]
        ];

        $winCondition = new ContinuousFullLengthLineWinCondition();
        self::assertSame(
            $user,
            $winCondition->check(
                $this->buildGameState(
                    $markRows,
                    $size
                )
            )
        );
    }

    /**
     * @test
     */
    public function itShouldReturnUserIfColumnFullOfSamePlayerMarks()
    {
        $user = $this->buildUser();

        $size = 3;
        $markRows = [
            [null, $user, null],
            [null, $user, null],
            [null, $user, null]
        ];

        $winCondition = new ContinuousFullLengthLineWinCondition();
        self::assertSame(
            $user,
            $winCondition->check(
                $this->buildGameState(
                    $markRows,
                    $size
                )
            )
        );
    }

    /**
     * @test
     */
    public function itShouldReturnUserIfDiagonalFullOfSamePlayerMarks()
    {
        $user = $this->buildUser();

        $size = 3;
        $markRows = [
            [null, null, $user],
            [null, $user, null],
            [$user, null, null]
        ];

        $winCondition = new ContinuousFullLengthLineWinCondition();
        self::assertSame(
            $user,
            $winCondition->check(
                $this->buildGameState(
                    $markRows,
                    $size
                )
            )
        );
    }

    private function buildUser()
    {
        return $this->prophesize(User::class)->reveal();
    }

    private function buildGameState(array $markRows = [], int $size = 0)
    {
        $prophecy = $this->prophesize(GridGameState::class);
        $prophecy->markRows()->willReturn($markRows);
        $prophecy->size()->willReturn($size);

        return $prophecy->reveal();
    }
}
