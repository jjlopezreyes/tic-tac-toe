<?php


namespace TicTacToe\Domain\Entity\Repository;

use Assertion\Assertion;
use TicTacToe\Domain\Entity\Entity;
use TicTacToe\Domain\Entity\ValueObject\Identity;

abstract class BaseEntityRepository implements EntityRepository
{
    protected const ENTITY_CLASS = Entity::class;
    protected const IDENTITY_CLASS = Identity::class;

    /**
     * @param Entity $entity
     * @throws \Assert\AssertionFailedException
     */
    public function save(Entity $entity)
    {
        $this->assertEntityClass($entity);
    }

    /**
     * @param Identity $identity
     * @return Entity
     * @throws \Assert\AssertionFailedException
     */
    public function get(Identity $identity)
    {
        $this->assertIdentityClass($identity);
    }

    /**
     * @param Entity $entity
     * @return mixed
     * @throws \Assert\AssertionFailedException
     */
    public function delete(Entity $entity)
    {
        $this->assertEntityClass($entity);
    }

    /**
     * @param Entity $entity
     * @throws \Assert\AssertionFailedException
     */
    private function assertEntityClass(Entity $entity): void
    {
        Assertion::isInstanceOf(
            $entity,
            static::ENTITY_CLASS,
            "Repository only accepts entities of type "
            . static::ENTITY_CLASS
        );
    }

    /**
     * @param Identity $identity
     */
    private function assertIdentityClass(Identity $identity): void
    {
        Assertion::isInstanceOf(
            $identity,
            static::IDENTITY_CLASS,
            "Repository only accepts identities of type "
            . static::IDENTITY_CLASS
        );
    }
}
