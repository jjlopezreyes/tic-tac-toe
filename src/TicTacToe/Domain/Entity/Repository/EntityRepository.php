<?php


namespace TicTacToe\Domain\Entity\Repository;


use TicTacToe\Domain\Entity\Entity;
use TicTacToe\Domain\Entity\Exception\EntityNotFoundDomainException;
use TicTacToe\Domain\Entity\ValueObject\Identity;

interface EntityRepository
{
    public function save(Entity $entity);

    /**
     * @param Identity $identity
     * @return Entity
     * @throws EntityNotFoundDomainException
     */
    public function get(Identity $identity);

    /**
     * @param Entity $entity
     * @return mixed
     * @throws EntityNotFoundDomainException
     */
    public function delete(Entity $entity);
}
