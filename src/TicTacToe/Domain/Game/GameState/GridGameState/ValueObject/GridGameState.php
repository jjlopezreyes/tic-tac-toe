<?php


namespace TicTacToe\Domain\Game\GameState\GridGameState\ValueObject;

use Assertion\Assertion;
use TicTacToe\Domain\Game\GameState\ValueObject\GameState;
use TicTacToe\Domain\User\Entity\User;

class GridGameState implements GameState
{
    private $size;
    private $markRows;

    public function __construct(int $size)
    {
        $this->size = $size;
        $markRows = [];
        for ($i = 0; $i < $size; $i++) {
            $markRows[$i] = array_fill(0, $size, null);
        }
        $this->markRows = $markRows;
    }

    public function placeMark(User $user, int $height, int $width)
    {
        Assertion::between($height, 0, $this->size-1,
            "Mark height must be within game grid boundaries");
        Assertion::between($width, 0, $this->size-1,
            "Mark width must be within game grid boundaries");
        Assertion::true(
            empty($this->markRows[$height][$width]),
            "Grid position must be empty in order to place a mark"
        );
        $this->markRows[$height][$width] = $user;
    }

    public function markRows(): array
    {
        return $this->markRows;
    }

    public function size(): int
    {
        return $this->size;
    }
}
