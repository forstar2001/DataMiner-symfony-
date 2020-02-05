<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use App\Entity as Entity;
use Doctrine\ORM\QueryBuilder;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\DBAL\Connection;

class WiimaxxLinkRepository extends EntityRepository
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

    public function create(array $data): Entity\WiimaxxLink
    {
        /* @var \App\Entity\WiimaxxLink $entity */
        $entity = new $this->_entityName;
        $entity->fileId = $this->propertyAccessor->getValue(
            $data,
            '[fileId]'
        );
        $entity->isPublic = $this->propertyAccessor->getValue(
            $data,
            '[isPublic]'
        );
        $entity->allowedTo = array_filter(
            array_values(
                $this->propertyAccessor->getValue(
                    $data,
                    '[allowedTo]'
                ) ?? []
            )
        );
        $entity->isVerified = $this->propertyAccessor->getValue(
            $data,
            '[isVerified]'
        );
        $entity->isGallery = $this->propertyAccessor->getValue(
            $data,
            '[isGallery]'
        );
        $entity->isProfile = $this->propertyAccessor->getValue(
            $data,
            '[isProfile]'
        );
        $entity->verifiedByUsername = $this->propertyAccessor->getValue(
            $data,
            '[verifiedByUsername]'
        );
        $entity->verifiedById = $this->propertyAccessor->getValue(
            $data,
            '[verifiedById]'
        );
        $entity->verifiedDate = $this->propertyAccessor->getValue(
            $data,
            '[verifiedDate]'
        );
        $entity->ownerId = $this->propertyAccessor->getValue(
            $data,
            '[ownerId]'
        );
        $entity->url = $this->propertyAccessor->getValue(
            $data,
            '[url]'
        );
        $entity->originalUrl = $this->propertyAccessor->getValue(
            $data,
            '[originalUrl]'
        );
        $entity->privateUrl = $this->propertyAccessor->getValue(
            $data,
            '[privateUrl]'
        );
        $entity->isAllowedToRequestor = $this->propertyAccessor->getValue(
            $data,
            '[isAllowedToRequestor]'
        );
        $entity->isHidden = $this->propertyAccessor->getValue(
            $data,
            '[isHidden]'
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
        $this->getEntityManager()->persist(
            $entity
        );

        return $entity;
    }

    public function findSomeAggregatedByWiimaxx(): array
    {
        $queryBuilder = $this->qbFindSomeAggregatedByWiimaxx();

        return $queryBuilder->getQuery()->getResult();
    }

    protected function qbFindSomeAggregatedByWiimaxx(): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder(
            'wiimaxxLink'
        );
        $queryBuilder->select(
            'wiimaxxNode.__uuid'
        )->join(
            'wiimaxxLink.wiimaxxNode',
            'wiimaxxNode'
        )->distinct();

        return $queryBuilder;
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
