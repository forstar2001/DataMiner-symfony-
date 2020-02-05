<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use App\Entity as Entity;
use Doctrine\ORM\QueryBuilder;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\DBAL\Connection;
use Symfony\Component\PropertyAccess\PropertyAccess;

class WiimaxxRepository extends EntityRepository
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

    public function create(array $data): Entity\Wiimaxx
    {
        /* @var \App\Entity\Wiimaxx $entity */
        $entity = new $this->_entityName;
        $entity->_id = $this->propertyAccessor->getValue(
            $data,
            '[_id]'
        );
        $entity->__isActive = true;
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

    public function update(Entity\Wiimaxx $entity, array $data): Entity\Wiimaxx
    {
        $entity->username = $this->propertyAccessor->getValue(
            $data,
            '[username]'
        );
        $entity->usernameLower = $this->propertyAccessor->getValue(
            $data,
            '[usernameLower]'
        );
        $entity->sourceId = $this->propertyAccessor->getValue(
            $data,
            '[sourceId]'
        );
        $entity->isAdult = $this->propertyAccessor->getValue(
            $data,
            '[isAdult]'
        );
        $entity->gender = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][gender]'
        );
        $entity->aboutMe = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][aboutMe]'
        );
        $entity->location = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][location]'
        );
        $entity->locationLocal = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][locationLocal]'
        );
        $entity->country = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][country]'
        );
        $entity->birthDay = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][birthDay]'
        );
        $entity->birthDayYear = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][birthDayYear]'
        );
        $entity->birthDayMonth = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][birthDayMonth]'
        );
        $entity->birthDayDay = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][birthDayDay]'
        );
        $entity->coordinatesLon = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][coordinates][lon]'
        );
        $entity->coordinatesLat = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][coordinates][lat]'
        );
        $entity->birthDayUpdatedDayIndex = $this->propertyAccessor->getValue(
            $data,
            '[profile][mainInfo][birthDayUpdatedDayIndex]'
        );
        $entity->ethnic = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][ethnic]'
        );
        $entity->lookingForGender = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][lookingFor]'
        );
        $entity->status = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][status]'
        );
        $entity->children = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][children]'
        );
        $entity->living = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][living]'
        );
        $entity->starSign = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][starSign]'
        );
        $entity->orientation = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][orientation]'
        );
        $entity->drinkingHabits = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][drinkingHabits]'
        );
        $entity->smokingHabits = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][smokingHabits]'
        );
        $entity->religion = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][religion]'
        );
        $entity->education = $this->propertyAccessor->getValue(
            $data,
            '[profile][personalInfo][education]'
        );
        $entity->height = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][height]'
        );
        $entity->weight = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][weight]'
        );
        $entity->bodyType = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][bodyType]'
        );
        $entity->hairColor = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][hairColor]'
        );
        $entity->eyeColor = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][eyeColor]'
        );
        $entity->bodyArt = $this->propertyAccessor->getValue(
            $data,
            '[profile][appearance][bodyArt]'
        );
        $entity->tags = array_filter(
            array_values(
                $this->propertyAccessor->getValue(
                    $data,
                    '[profile][tags]'
                ) ?? []
            )
        );
        $entity->createTime = $this->propertyAccessor->getValue(
            $data,
            '[createTime]'
        );
        $entity->updateTime = $this->propertyAccessor->getValue(
            $data,
            '[updateTime]'
        );
        $entity->updatedBy = $this->propertyAccessor->getValue(
            $data,
            '[updatedBy]'
        );
        $entity->updatedByUsername = $this->propertyAccessor->getValue(
            $data,
            '[updatedByUsername]'
        );
        $entity->queueLanguage = $this->propertyAccessor->getValue(
            $data,
            '[queueLanguage]'
        );
        $entity->isClient = $this->propertyAccessor->getValue(
            $data,
            '[isClient]'
        );
        $entity->virtualState = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualState]'
        );
        $entity->virtualCreatedBy = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualCreatedBy]'
        );
        $entity->virtualCreatedByUsername = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualCreatedByUsername]'
        );
        $entity->virtualSessionCount = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualSessionCount]'
        );
        $entity->virtualSentMessagesCount = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualSentMessagesCount]'
        );

        if ($this->propertyAccessor->isReadable($data, '[virtualProfileData][virtualNewMyStory][name]')) {
            $entity->virtualName = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][name]'
            );
            $entity->virtualStatus = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][status]'
            );
            $entity->virtualLanguage = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][language]'
            );
            $entity->virtualNationality = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][nationality]'
            );
            $entity->virtualYearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][yearOfBirth]'
            );
            $entity->virtualAge = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual][age]'
            );
            $entity->virtual2Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][name]'
            );
            $entity->virtual2Status = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][status]'
            );
            $entity->virtual2Language = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][language]'
            );
            $entity->virtual2Nationality = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][nationality]'
            );
            $entity->virtual2YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][yearOfBirth]'
            );
            $entity->virtual2Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][virtual2][age]'
            );
            $entity->homeCity = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][home][city]'
            );
            $entity->homeArea = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][home][area]'
            );
            $entity->homeLiving = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][home][living]'
            );
            $entity->jobTitle = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][job][title]'
            );
            $entity->jobHours = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][job][hours]'
            );
            $entity->jobDays = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][job][days]'
            );
            $entity->partnerName = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][name]'
            );
            $entity->partnerLiving = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][living]'
            );
            $entity->partnerGender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][gender]'
            );
            $entity->partnerYearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][yearOfBirth]'
            );
            $entity->partnerYod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][yod]'
            );
            $entity->partnerAge = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][partner][age]'
            );
            $entity->child1Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][name]'
            );
            $entity->child1Living = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][living]'
            );
            $entity->child1Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][gender]'
            );
            $entity->child1YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][yearOfBirth]'
            );
            $entity->child1Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][yod]'
            );
            $entity->child1Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child1][age]'
            );
            $entity->child2Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][name]'
            );
            $entity->child2Living = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][living]'
            );
            $entity->child2Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][gender]'
            );
            $entity->child2YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][yearOfBirth]'
            );
            $entity->child2Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][yod]'
            );
            $entity->child2Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child2][age]'
            );
            $entity->child3Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][name]'
            );
            $entity->child3Living = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][living]'
            );
            $entity->child3Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][gender]'
            );
            $entity->child3YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][yearOfBirth]'
            );
            $entity->child3Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][yod]'
            );
            $entity->child3Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][child3][age]'
            );
            $entity->motherName = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][name]'
            );
            $entity->motherCity = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][city]'
            );
            $entity->motherStatus = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][status]'
            );
            $entity->motherYearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][yearOfBirth]'
            );
            $entity->motherYod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][yod]'
            );
            $entity->motherAge = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][mother][age]'
            );
            $entity->fatherName = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][name]'
            );
            $entity->fatherCity = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][city]'
            );
            $entity->fatherStatus = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][status]'
            );
            $entity->fatherYearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][yearOfBirth]'
            );
            $entity->fatherYod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][yod]'
            );
            $entity->fatherAge = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][father][age]'
            );
            $entity->sibling1Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][name]'
            );
            $entity->sibling1City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][city]'
            );
            $entity->sibling1Status = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][status]'
            );
            $entity->sibling1Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][gender]'
            );
            $entity->sibling1YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][yearOfBirth]'
            );
            $entity->sibling1Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][yod]'
            );
            $entity->sibling1Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling1][age]'
            );
            $entity->sibling2Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][name]'
            );
            $entity->sibling2City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][city]'
            );
            $entity->sibling2Status = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][status]'
            );
            $entity->sibling2Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][gender]'
            );
            $entity->sibling2YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][yearOfBirth]'
            );
            $entity->sibling2Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][yod]'
            );
            $entity->sibling2Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling2][age]'
            );
            $entity->sibling3Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][name]'
            );
            $entity->sibling3City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][city]'
            );
            $entity->sibling3Status = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][status]'
            );
            $entity->sibling3Gender = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][gender]'
            );
            $entity->sibling3YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][yearOfBirth]'
            );
            $entity->sibling3Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][yod]'
            );
            $entity->sibling3Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][sibling3][age]'
            );
            $entity->pet1Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][name]'
            );
            $entity->pet1Type = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][type]'
            );
            $entity->pet1Breeds = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][breeds]'
            );
            $entity->pet1YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][yearOfBirth]'
            );
            $entity->pet1Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][yod]'
            );
            $entity->pet1Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet1][age]'
            );
            $entity->pet2Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][name]'
            );
            $entity->pet2Type = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][type]'
            );
            $entity->pet2Breeds = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][breeds]'
            );
            $entity->pet2YearOfBirth = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][yearOfBirth]'
            );
            $entity->pet2Yod = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][yod]'
            );
            $entity->pet2Age = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][pet2][age]'
            );
            $entity->vehicle1Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle1][name]'
            );
            $entity->vehicle1Model = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle1][model]'
            );
            $entity->vehicle1Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle1][year]'
            );
            $entity->vehicle1Color = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle1][colour]'
            );
            $entity->vehicle2Name = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle2][name]'
            );
            $entity->vehicle2Model = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle2][model]'
            );
            $entity->vehicle2Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle2][year]'
            );
            $entity->vehicle2Color = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][vehicle2][colour]'
            );
            $entity->interests = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][interests]'
                    ) ?? []
                )
            );
            $entity->movies = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][movies]'
                    ) ?? []
                )
            );
            $entity->music = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][music]'
                    ) ?? []
                )
            );
            $entity->foods = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][foods]'
                    ) ?? []
                )
            );
            $entity->traveled1Country = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled1][country]'
            );
            $entity->traveled1City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled1][city]'
            );
            $entity->traveled1Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled1][year]'
            );
            $entity->traveled2Country = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled2][country]'
            );
            $entity->traveled2City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled2][city]'
            );
            $entity->traveled2Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled2][year]'
            );
            $entity->traveled3Country = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled3][country]'
            );
            $entity->traveled3City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled3][city]'
            );
            $entity->traveled3Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled3][year]'
            );
            $entity->traveled4Country = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled4][country]'
            );
            $entity->traveled4City = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled4][city]'
            );
            $entity->traveled4Year = $this->propertyAccessor->getValue(
                $data,
                '[virtualProfileData][virtualNewMyStory][traveled4][year]'
            );
            $entity->personality = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][personality]'
                    ) ?? []
                )
            );
            $entity->lookingFor = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][lookingFor]'
                    ) ?? []
                )
            );
            $entity->miscellaneous = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][miscellaneous]'
                    ) ?? []
                )
            );
            $entity->sexInterests = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][sexInterests]'
                    ) ?? []
                )
            );
            $entity->sexToys = array_filter(
                array_values(
                    $this->propertyAccessor->getValue(
                        $data,
                        '[virtualProfileData][virtualNewMyStory][sexToys]'
                    ) ?? []
                )
            );
        }

        $entity->databaseId = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][databaseId]'
        );
        $entity->chatStyle = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][chatStyle]'
        );
        $entity->virtualReceivedMessagesCount = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualReceivedMessagesCount]'
        );
        $entity->virtualApprovedTime = $this->propertyAccessor->getValue(
            $data,
            '[virtualProfileData][virtualApprovedTime]'
        );
        $entity->approvedImagesCount = $this->propertyAccessor->getValue(
            $data,
            '[approvedImagesCount]'
        );
        $entity->isOnline = $this->propertyAccessor->getValue(
            $data,
            '[isOnline]'
        );
        $entity->melixasNode = $this->propertyAccessor->getValue(
            $data,
            '[melixasNode]'
        );
        $entity->virtualTrackingLinkNode = $this->propertyAccessor->getValue(
            $data,
            '[virtualTrackingLinkNode]'
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

    public function findSomeByIsActiveNotInUuid(bool $isActive, array $uuid, int $limit = null): array
    {
        $queryBuilder = $this->qbFindSomeByIsActiveNotInUuid(
            ...func_get_args()
        );

        return $queryBuilder->getQuery()->getResult();
    }

    protected function qbFindSomeByIsActiveNotInUuid(bool $isActive, array $uuid, ?int $limit): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder(
            'wiimaxx'
        );
        $queryBuilder->where(
            $queryBuilder->expr()->andX()->addMultiple(
                call_user_func(
                    function () use ($queryBuilder, $uuid): array {
                        $criteria = [
                            $queryBuilder->expr()->eq(
                                'wiimaxx.__isActive',
                                ':isActive'
                            )
                        ];

                        if ($uuid) {
                            $criteria[] = $queryBuilder->expr()->notIn(
                                'wiimaxx.__uuid',
                                ':uuid'
                            );
                        }

                        return $criteria;
                    }
                )
            )
        )->setMaxResults(
            $limit
        );
        $queryBuilder->setParameters(
            new ArrayCollection(
                call_user_func(
                    function () use ($isActive, $uuid): array {
                        $parameters = [
                            new Parameter(
                                'isActive',
                                $isActive
                            )
                        ];

                        if ($uuid) {
                            $parameters[] = new Parameter(
                                'uuid',
                                $uuid,
                                Connection::PARAM_STR_ARRAY
                            );
                        }

                        return $parameters;
                    }
                )
            )
        );

        return $queryBuilder;
    }

    public function persist(Entity\Wiimaxx $entity): void
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
