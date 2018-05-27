<?php


namespace TicTacToe\Infrastructure\User\Entity\Repository;

use TicTacToe\Domain\User\Entity\Repository\UserRepository;
use TicTacToe\Domain\User\Entity\User;
use TicTacToe\Domain\User\ValueObject\UserIdentity;
use TicTacToe\Infrastructure\Entity\Repository\EntityRepositoryInMemoryImpl;

class UserRepositoryInMemoryImpl extends EntityRepositoryInMemoryImpl implements UserRepository
{
    protected const ENTITY_CLASS = User::class;
    protected const IDENTITY_CLASS = UserIdentity::class;
}
