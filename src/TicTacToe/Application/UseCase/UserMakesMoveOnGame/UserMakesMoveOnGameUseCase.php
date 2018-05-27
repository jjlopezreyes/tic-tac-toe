<?php


namespace TicTacToe\Application\UseCase\UserMakesMoveOnGame;

use TicTacToe\Domain\Game\Entity\Repository\GameRepository;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMove;
use TicTacToe\Domain\Move\GridGameStateMove\ValueObject\PlaceSingleMarkerGridGameStateMoveParameters;
use TicTacToe\Domain\User\Entity\Repository\UserRepository;
use TicTacToe\Domain\User\ValueObject\UserIdentity;

class UserMakesMoveOnGameUseCase
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

    public function execute(UserMakesMoveOnGameRequest $request): UserMakesMoveOnGameResponse
    {
        $user = $this->userRepository->get(
            new UserIdentity($request->userId())
        );

        $game = $this->gameRepository->get(
            new GameIdentity($request->gameId())
        );

        $moveParams = new PlaceSingleMarkerGridGameStateMoveParameters(
            $request->height(),
            $request->width()
        );

        $game->make(
            $user,
            new PlaceSingleMarkerGridGameStateMove(),
            $moveParams
        );

        $this->gameRepository->save($game);

        return new UserMakesMoveOnGameResponse();
    }
}
