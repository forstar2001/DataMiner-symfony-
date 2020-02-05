<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use App\Entity as Entity;

use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;

class WiimaxxVirtualTrackingLinkRepository extends EntityRepository
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

    public function create(array $data): Entity\WiimaxxVirtualTrackingLink
    {
        /* @var \App\Entity\WiimaxxVirtualTrackingLink $entity */
        $entity = new $this->_entityName;
        $entity->_id = $this->propertyAccessor->getValue(
            $data,
            '[_id]'
        );
        $entity->siteId = $this->propertyAccessor->getValue(
            $data,
            '[siteId]'
        );
        $entity->contractorId = $this->propertyAccessor->getValue(
            $data,
            '[contractorId]'
        );
        $entity->description = $this->propertyAccessor->getValue(
            $data,
            '[description]'
        );
        $entity->linkType = $this->propertyAccessor->getValue(
            $data,
            '[linkType]'
        );
        $entity->virtualId = $this->propertyAccessor->getValue(
            $data,
            '[virtualId]'
        );
        $entity->countryCode = $this->propertyAccessor->getValue(
            $data,
            '[countryCode]'
        );
        $entity->platform = $this->propertyAccessor->getValue(
            $data,
            '[platform]'
        );
        $entity->publicAccessKey = $this->propertyAccessor->getValue(
            $data,
            '[publicAccessKey]'
        );
        $entity->afterRegisterLandTo = $this->propertyAccessor->getValue(
            $data,
            '[afterRegisterLandTo]'
        );
        $entity->landingOverride = $this->propertyAccessor->getValue(
            $data,
            '[landingOverride]'
        );
        $entity->wiimaxxNode = null;
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

    public function update(Entity\WiimaxxVirtualTrackingLink $entity, array $data): Entity\WiimaxxVirtualTrackingLink
    {
        $entity->wiimaxxNode = $this->propertyAccessor->getValue(
            $data,
            '[wiimaxxNode]'
        );

        $this->persist(
            $entity
        );

        return $entity;
    }

    public function findSomeByIsActiveNotInDescription(bool $isActive, array $description, int $limit = null): array
    {
        $queryBuilder = $this->qbFindSomeByIsActiveNotInDescription(
            ...func_get_args()
        );

        return $queryBuilder->getQuery()->getResult();
    }

    protected function qbFindSomeByIsActiveNotInDescription(bool $isActive, array $description, ?int $limit): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder(
            'wiimaxxVirtualTrackingLink'
        );
        $queryBuilder->where(
            $queryBuilder->expr()->andX()->addMultiple(
                [
                    $queryBuilder->expr()->notIn(
                        'wiimaxxVirtualTrackingLink.description',
                        ':description'
                    ),
                    $queryBuilder->expr()->eq(
                        'wiimaxxVirtualTrackingLink.__isActive',
                        ':isActive'
                    ),
                ]
            )
        )->setMaxResults(
            $limit
        );
        $queryBuilder->setParameters(
            new ArrayCollection(
                [
                    new Parameter(
                        'description',
                        $description,
                        Connection::PARAM_STR_ARRAY
                    ),
                    new Parameter(
                        'isActive',
                        $isActive
                    ),
                ]
            )
        );

        return $queryBuilder;
    }

    public function persist(Entity\WiimaxxVirtualTrackingLink $entity): void
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
