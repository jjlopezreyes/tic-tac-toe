<?php


namespace TicTacToe\Infrastructure\Presentation\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers\CreateGameBetweenTwoUsersRequest;
use TicTacToe\Application\UseCase\CreateGameBetweenTwoUsers\CreateGameBetweenTwoUsersUseCase;
use TicTacToe\Infrastructure\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;

class CreateGameBetweenTwoUsersCommand extends Command
{
    const FIRST_USER_ID_ARGUMENT = 'firstUserId';
    const SECOND_USER_ID_ARGUMENT = 'secondUserId';
    const GRID_SIZE_ARGUMENT = 'gridSize';

    protected function configure()
    {
        $this
            ->setName('create-game-between-two-users')
            ->setDescription(
                'Given two user Ids and a Game Grid size, creates Game between given users'
            )->addArgument(
                self::FIRST_USER_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the First User Id (UUID4)'
            )->addArgument(
                self::SECOND_USER_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the Second User Id (UUID4)'
            )->addArgument(
                self::GRID_SIZE_ARGUMENT,
                InputArgument::REQUIRED,
                'Size of the Game Grid'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = new UserRepositoryInMemoryImpl();
        $gameRepository = new GameRepositoryInMemoryImpl();

        $useCase = new CreateGameBetweenTwoUsersUseCase(
            $userRepository,
            $gameRepository
        );
        $request = new CreateGameBetweenTwoUsersRequest(
            $input->getArgument(self::FIRST_USER_ID_ARGUMENT),
            $input->getArgument(self::SECOND_USER_ID_ARGUMENT),
            $input->getArgument(self::GRID_SIZE_ARGUMENT)
        );

        $response = $useCase->execute($request);

        $output->writeln("Created Game Id: ".$response->gameId());
    }
}
