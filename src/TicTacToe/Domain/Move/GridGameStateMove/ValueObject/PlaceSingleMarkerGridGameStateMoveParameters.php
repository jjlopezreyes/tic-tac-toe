<?php


namespace TicTacToe\Domain\Move\GridGameStateMove\ValueObject;

use TicTacToe\Domain\Move\ValueObject\MoveParameters;

class PlaceSingleMarkerGridGameStateMoveParameters implements MoveParameters
{
    private $height;
    private $width;

    public function __construct(
        int $height,
        int $width
    ) {
        $this->height = $height;
        $this->width = $width;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function width(): int
    {
        return $this->width;
    }
}
