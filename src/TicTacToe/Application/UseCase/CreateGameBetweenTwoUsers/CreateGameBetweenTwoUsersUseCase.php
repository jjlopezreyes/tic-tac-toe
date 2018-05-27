<?php


namespace TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers;

use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Domain\Game\Entity\Repository\GameRepository;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;
use TicTacToe\Domain\Game\GameState\GridGameState\ValueObject\GridGameState;
use TicTacToe\Domain\User\Entity\Repository\UserRepository;
use TicTacToe\Domain\User\ValueObject\UserIdentity;
use TicTacToe\Domain\WinCondition\GridGameStateWinCondition\ValueObject\ContinuousFullLengthLineWinCondition;

class CreateGameBetweenTwoUsersUseCase
{
    /** @var UserRepository */
    private $userRepository;
    /** @var GameRepository */
    private $gameRepository;

    public function __construct(
        UserRepository $userRepository,
        GameRepository $gameRepository
    ) {
        $this->userRepository = $userRepository;
        $this->gameRepository = $gameRepository;
    }

    public function execute(CreateGameBetweenTwoUsersRequest $request): CreateGameBetweenTwoUsersResponse
    {
        $firstUser = $this->userRepository->get(
            new UserIdentity($request->firstUserId())
        );

        $secondUser = $this->userRepository->get(
            new UserIdentity($request->secondUserId())
        );

        $game = new Game(
            new GameIdentity(),
            [
                $firstUser,
                $secondUser
            ],
            new GridGameState(
                $request->gridSize()
            ),
            [
                new ContinuousFullLengthLineWinCondition()
            ]
        );

        $this->gameRepository->save($game);

        return new CreateGameBetweenTwoUsersResponse(
            $game->identity()->id()
        );
    }
}
