<?php


namespace TicTacToe\Infrastructure\Presentation\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UseCase\UserMakesMoveOnGame\UserMakesMoveOnGameRequest;
use TicTacToe\Application\UseCase\UserMakesMoveOnGame\UserMakesMoveOnGameUseCase;
use TicTacToe\Domain\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;

class UserMakesMoveOnGameCommand extends Command
{
    const USER_ID_ARGUMENT = 'userId';
    const GAME_ID_ARGUMENT = 'gameId';
    const HEIGHT_ARGUMENT = 'height';
    const WIDTH_ARGUMENT = 'width';

    protected function configure()
    {
        $this
            ->setName('user-makes-move-on-game')
            ->setDescription(
                'Given a User id, a Game id, a height and a width, places the user mark on the game grid at the given coordinates'
            )->addArgument(
                self::USER_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the User Id (UUID4)'
            )->addArgument(
                self::GAME_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the Game Id (UUID4)'
            )->addArgument(
                self::HEIGHT_ARGUMENT,
                InputArgument::REQUIRED,
                'Height to place mark at'
            )->addArgument(
                self::WIDTH_ARGUMENT,
                InputArgument::REQUIRED,
                'Width to place mark at'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = new UserRepositoryInMemoryImpl();
        $gameRepository = new GameRepositoryInMemoryImpl();

        $useCase = new UserMakesMoveOnGameUseCase(
            $userRepository,
            $gameRepository
        );

        $userId = $input->getArgument(self::USER_ID_ARGUMENT);
        $gameId = $input->getArgument(self::GAME_ID_ARGUMENT);
        $height = $input->getArgument(self::HEIGHT_ARGUMENT);
        $width = $input->getArgument(self::WIDTH_ARGUMENT);

        $request = new UserMakesMoveOnGameRequest(
            $userId,
            $gameId,
            $height,
            $width
        );

        $useCase->execute($request);

        $output->writeln("Placed user $userId mark on game $gameId at height $height and width $width");
    }
}
