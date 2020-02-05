<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use App\Entity as Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

class MelixasRepository extends EntityRepository
{
    protected $propertyAccessor;

    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $class)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

        parent::__construct(
            $em,
            $class
        );
    }

    public function create(array $data): Entity\Melixas
    {
        /* @var \App\Entity\Melixas $entity */
        $entity = new $this->_entityName;
        $entity->_id = $this->propertyAccessor->getValue(
            $data,
            '[_id]'
        );
        $entity->birthDay = $this->propertyAccessor->getValue(
            $data,
            '[birthDay]'
        );
        $entity->country = $this->propertyAccessor->getValue(
            $data,
            '[country]'
        );
        $entity->gender = $this->propertyAccessor->getValue(
            $data,
            '[gender]'
        );
        $entity->imageCount = $this->propertyAccessor->getValue(
            $data,
            '[imageCount]'
        );
        $entity->isEmailVerified = $this->propertyAccessor->getValue(
            $data,
            '[isEmailVerified]'
        );
        $entity->isProfileVerified = $this->propertyAccessor->getValue(
            $data,
            '[isProfileVerified]'
        );
        $entity->location = $this->propertyAccessor->getValue(
            $data,
            '[location]'
        );
        $entity->locationLocal = $this->propertyAccessor->getValue(
            $data,
            '[locationLocal]'
        );
        $entity->username = $this->propertyAccessor->getValue(
            $data,
            '[username]'
        );
        $entity->isOnline = $this->propertyAccessor->getValue(
            $data,
            '[isOnline]'
        );
        $entity->isFavorited = $this->propertyAccessor->getValue(
            $data,
            '[isFavorited]'
        );
        $entity->isFlirtSent = $this->propertyAccessor->getValue(
            $data,
            '[isFlirtSent]'
        );
        $entity->searchTopStopExpiresOn = $this->propertyAccessor->getValue(
            $data,
            '[searchTopStopExpiresOn]'
        );
        $entity->isNew = $this->propertyAccessor->getValue(
            $data,
            '[isNew]'
        );
        $entity->timezoneName = $this->propertyAccessor->getValue(
            $data,
            '[timezoneName]'
        );
        $entity->wiimaxxNode = $this->propertyAccessor->getValue(
            $data,
            '[wiimaxxNode]'
        );
        $entity->__isActive = true;
        $entity->__rawRecord = $this->propertyAccessor->getValue(
            $data,
            '[__rawRecord]'
        );
        $entity->__rawRequest[] = $this->propertyAccessor->getValue(
            $data,
            '[__rawRequest]'
        );
        $entity->__rawResponse[] = $this->propertyAccessor->getValue(
            $data,
            '[__rawResponse]'
        );
        $this->persist(
            $entity
        );

        return $entity;
    }

    public function persist(Entity\Melixas $entity): void
    {
        $this->getEntityManager()->persist(
            $entity
        );
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
