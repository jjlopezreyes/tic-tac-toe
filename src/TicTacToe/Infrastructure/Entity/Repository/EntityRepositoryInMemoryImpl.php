<?php


namespace TicTacToe\Infrastructure\Entity\Repository;

use TicTacToe\Domain\Entity\Entity;
use TicTacToe\Domain\Entity\Exception\EntityNotFoundDomainException;
use TicTacToe\Domain\Entity\Repository\BaseEntityRepository;
use TicTacToe\Domain\Entity\ValueObject\Identity;

class EntityRepositoryInMemoryImpl extends BaseEntityRepository
{
    private $entities;

    public function __construct($games = [])
    {
        $this->entities = $games;
    }

    /**
     * @param Entity $entity
     * @throws \Assert\AssertionFailedException
     */
    public function save(Entity $entity)
    {
        parent::save($entity);

        $this->entities[$entity->identity()->id()] = $entity;
    }

    /**
     * @param Identity $identity
     * @return Entity
     * @throws EntityNotFoundDomainException
     * @throws \Assert\AssertionFailedException
     */
    public function get(Identity $identity): Entity
    {
        parent::get($identity);

        if (empty($this->entities[$identity->id()])) {
            throw new EntityNotFoundDomainException("Entity with id ".$identity->id()." not found");
        }

        return $this->entities[$identity->id()];
    }

    /**
     * @param Entity $entity
     * @return mixed
     * @throws EntityNotFoundDomainException
     * @throws \Assert\AssertionFailedException
     */
    public function delete(Entity $entity)
    {
        parent::delete($entity);

        if (empty($this->entities[$entity->identity()->id()])) {
            throw new EntityNotFoundDomainException();
        }

        unset($this->entities[$entity->identity()->id()]);
    }

    public function getAll()
    {
        return $this->entities;
    }
}
