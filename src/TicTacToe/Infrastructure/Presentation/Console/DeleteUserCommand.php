<?php


namespace TicTacToe\Infrastructure\Presentation\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UseCase\DeleteUser\DeleteUserRequest;
use TicTacToe\Application\UseCase\DeleteUser\DeleteUserUseCase;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;

class DeleteUserCommand extends Command
{
    const USER_ID_ARGUMENT = 'userId';

    protected function configure()
    {
        $this
            ->setName('delete-user')
            ->setDescription(
                'Given a user Id, deletes user'
            )->addArgument(
                self::USER_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the User Id (UUID4)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = new UserRepositoryInMemoryImpl();

        $useCase = new DeleteUserUseCase(
            $userRepository
        );

        $userId = $input->getArgument(self::USER_ID_ARGUMENT);

        $request = new DeleteUserRequest(
            $userId
        );

        $useCase->execute($request);

        $output->writeln("Deleted User Id: ".$userId);
    }
}
