<?php


namespace TicTacToe\Infrastructure\Game\Entity\Repository;

use TicTacToe\Domain\Game\Entity\Game;
use TicTacToe\Domain\Game\Entity\Repository\GameRepository;
use TicTacToe\Domain\Game\Entity\ValueObject\GameIdentity;
use TicTacToe\Infrastructure\Entity\Repository\EntityRepositoryInMemoryImpl;

class GameRepositoryInMemoryImpl extends EntityRepositoryInMemoryImpl implements GameRepository
{
    protected const ENTITY_CLASS = Game::class;
    protected const IDENTITY_CLASS = GameIdentity::class;
}
