<?php


namespace TicTacToe\Infrastructure\Presentation\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UseCase\CheckGameWinner\CheckGameWinnerRequest;
use TicTacToe\Application\UseCase\CheckGameWinner\CheckGameWinnerUseCase;
use TicTacToe\Infrastructure\Game\Entity\Repository\GameRepositoryInMemoryImpl;
use TicTacToe\Domain\User\Entity\User;

class CheckGameWinnerCommand extends Command
{
    const GAME_ID_ARGUMENT = 'gameId';

    protected function configure()
    {
        $this
            ->setName('check-game-winner')
            ->setDescription(
                'Given a Game Id, returns the winner, or null if there is no winner'
            )->addArgument(
                self::GAME_ID_ARGUMENT,
                InputArgument::REQUIRED,
                'String representation of the Game Id (UUID4)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $gameRepository = new GameRepositoryInMemoryImpl();

        $useCase = new CheckGameWinnerUseCase(
            $gameRepository
        );
        $request = new CheckGameWinnerRequest(
            $input->getArgument(self::GAME_ID_ARGUMENT)
        );

        $response = $useCase->execute($request);

        $winner = $response->winner();

        if ($winner instanceof User) {
            $output->writeln("Winner is ".$winner->identity()->id());
        } else {
            $output->writeln("Game is not yet finished");
        }
    }
}
