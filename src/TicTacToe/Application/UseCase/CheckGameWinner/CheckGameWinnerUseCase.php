<?php


namespace TicTacToe\Application\UseCase\CheckGameWinner;

use TicTacToe\Domain\Game\Entity\Repository\GameRepository;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;

class CheckGameWinnerUseCase
{
    /** @var GameRepository */
    private $gameRepository;

    public function __construct(
        GameRepository $gameRepository
    ) {
        $this->gameRepository = $gameRepository;
    }

    public function execute(CheckGameWinnerRequest $request): CheckGameWinnerResponse
    {
        $game = $this->gameRepository->get(
            new GameIdentity($request->gameId())
        );

        $winner = $game->checkWinConditions();

        return new CheckGameWinnerResponse(
            $winner
        );
    }
}
