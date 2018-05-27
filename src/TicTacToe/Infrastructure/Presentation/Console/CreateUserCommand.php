<?php


namespace TicTacToe\Infrastructure\Presentation\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UseCase\CreateUser\CreateUserRequest;
use TicTacToe\Application\UseCase\CreateUser\CreateUserUseCase;
use TicTacToe\Infrastructure\User\Entity\Repository\UserRepositoryInMemoryImpl;

class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create-user')
            ->setDescription(
                'Creates new User'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = new UserRepositoryInMemoryImpl();

        $useCase = new CreateUserUseCase(
            $userRepository
        );

        $request = new CreateUserRequest();

        $response = $useCase->execute($request);

        $output->writeln("Created User Id: ".$response->userId());
    }
}
