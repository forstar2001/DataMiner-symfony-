<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;

use App\Entity\Traits as Traits;

/**
 * @ORM\Entity(
 *     repositoryClass="App\Repository\WiimaxxRepository"
 * )
 * @ORM\HasLifecycleCallbacks
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "path"="/"
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "path"="/{id}"
 *         }
 *     },
 *     routePrefix="/node/wiimaxx"
 * )
 */
class Wiimaxx
{
    use Traits\UuidTrait;

    use Traits\LifecycleEventsTrait;

    use Traits\StatesTrait;

    use Traits\RawTrait;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $_id;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $username;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $usernameLower;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $sourceId;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isAdult;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $gender;

    /**
     * @ORM\Column(
     *     type="text"
     * )
     */
    public $aboutMe;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $location;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $locationLocal;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $country;

    /**
     * @ORM\Column(
     *     type="bigint"
     * )
     */
    public $birthDay;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $birthDayYear;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $birthDayMonth;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $birthDayDay;

    /**
     * @ORM\Column(
     *     type="float"
     * )
     */
    public $coordinatesLon;

    /**
     * @ORM\Column(
     *     type="float"
     * )
     */
    public $coordinatesLat;

    /**
     * @ORM\Column(
     *     type="integer",
     *     nullable=true
     * )
     */
    public $birthDayUpdatedDayIndex;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $ethnic;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $lookingForGender;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $status;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $children;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $living;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $starSign;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $orientation;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $drinkingHabits;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $smokingHabits;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $religion;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $education;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $height;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $weight;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $bodyType;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $hairColor;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $eyeColor;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $bodyArt;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $tags;

    /**
     * @ORM\Column(
     *     type="bigint"
     * )
     */
    public $createTime;

    /**
     * @ORM\Column(
     *     type="bigint"
     * )
     */
    public $updateTime;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $updatedBy;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $updatedByUsername;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $queueLanguage;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isClient;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $virtualState;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $virtualCreatedBy;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $virtualCreatedByUsername;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $virtualSessionCount;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $virtualSentMessagesCount;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $virtualName;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $virtualStatus;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $virtualLanguage;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $virtualNationality;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $virtualYearOfBirth;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $virtualAge;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="virtual2_name",
     *     nullable=true
     * )
     */
    public $virtual2Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="virtual2_status",
     *     nullable=true
     * )
     */
    public $virtual2Status;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="virtual2_language",
     *     nullable=true
     * )
     */
    public $virtual2Language;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="virtual2_nationality",
     *     nullable=true
     * )
     */
    public $virtual2Nationality;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     name="virtual2_year_of_birth",
     *     nullable=true
     * )
     */
    public $virtual2YearOfBirth;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     name="virtual2_age",
     *     nullable=true
     * )
     */
    public $virtual2Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $homeCity;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $homeArea;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $homeLiving;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $jobTitle;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $jobHours;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $jobDays;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerName;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerLiving;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerGender;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerYearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerYod;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $partnerAge;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child1Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child1Living;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child1Gender;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child1YearOfBirth;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child1Yod;

    /**
     * @ORM\Column(
     *     type="decimal",
     *     nullable=true
     * )
     */
    public $child1Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child2Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child2Living;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child2Gender;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child2YearOfBirth;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child2Yod;

    /**
     * @ORM\Column(
     *     type="decimal",
     *     nullable=true
     * )
     */
    public $child2Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child3Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child3Living;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $child3Gender;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child3YearOfBirth;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $child3Yod;

    /**
     * @ORM\Column(
     *     type="decimal",
     *     nullable=true
     * )
     */
    public $child3Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherName;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherCity;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherStatus;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherYearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherYod;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $motherAge;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherName;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherCity;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherStatus;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherYearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherYod;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $fatherAge;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_name",
     *     nullable=true
     * )
     */
    public $sibling1Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_city",
     *     nullable=true
     * )
     */
    public $sibling1City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_status",
     *     nullable=true
     * )
     */
    public $sibling1Status;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_gender",
     *     nullable=true
     * )
     */
    public $sibling1Gender;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_year_of_birth",
     *     nullable=true
     * )
     */
    public $sibling1YearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_yod",
     *     nullable=true
     * )
     */
    public $sibling1Yod;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling1_age",
     *     nullable=true
     * )
     */
    public $sibling1Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_name",
     *     nullable=true
     * )
     */
    public $sibling2Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_city",
     *     nullable=true
     * )
     */
    public $sibling2City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_status",
     *     nullable=true
     * )
     */
    public $sibling2Status;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_gender",
     *     nullable=true
     * )
     */
    public $sibling2Gender;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_year_of_birth",
     *     nullable=true
     * )
     */
    public $sibling2YearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_yod",
     *     nullable=true
     * )
     */
    public $sibling2Yod;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling2_age",
     *     nullable=true
     * )
     */
    public $sibling2Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_name",
     *     nullable=true
     * )
     */
    public $sibling3Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_city",
     *     nullable=true
     * )
     */
    public $sibling3City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_status",
     *     nullable=true
     * )
     */
    public $sibling3Status;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_gender",
     *     nullable=true
     * )
     */
    public $sibling3Gender;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_year_of_birth",
     *     nullable=true
     * )
     */
    public $sibling3YearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_yod",
     *     nullable=true
     * )
     */
    public $sibling3Yod;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="sibling3_age",
     *     nullable=true
     * )
     */
    public $sibling3Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_name",
     *     nullable=true
     * )
     */
    public $pet1Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_type",
     *     nullable=true
     * )
     */
    public $pet1Type;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_breeds",
     *     nullable=true
     * )
     */
    public $pet1Breeds;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_year_of_birth",
     *     nullable=true
     * )
     */
    public $pet1YearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_yod",
     *     nullable=true
     * )
     */
    public $pet1Yod;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet1_age",
     *     nullable=true
     * )
     */
    public $pet1Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_name",
     *     nullable=true
     * )
     */
    public $pet2Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_type",
     *     nullable=true
     * )
     */
    public $pet2Type;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_breeds",
     *     nullable=true
     * )
     */
    public $pet2Breeds;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_year_of_birth",
     *     nullable=true
     * )
     */
    public $pet2YearOfBirth;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_yod",
     *     nullable=true
     * )
     */
    public $pet2Yod;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="pet2_age",
     *     nullable=true
     * )
     */
    public $pet2Age;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle1_name",
     *     nullable=true
     * )
     */
    public $vehicle1Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle1_model",
     *     nullable=true
     * )
     */
    public $vehicle1Model;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle1_year",
     *     nullable=true
     * )
     */
    public $vehicle1Year;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle1_color",
     *     nullable=true
     * )
     */
    public $vehicle1Color;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle2_name",
     *     nullable=true
     * )
     */
    public $vehicle2Name;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle2_model",
     *     nullable=true
     * )
     */
    public $vehicle2Model;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle2_year",
     *     nullable=true
     * )
     */
    public $vehicle2Year;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="vehicle2_color",
     *     nullable=true
     * )
     */
    public $vehicle2Color;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $interests;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $movies;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $music;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $foods;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled1_country",
     *     nullable=true
     * )
     */
    public $traveled1Country;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled1_city",
     *     nullable=true
     * )
     */
    public $traveled1City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled1_year",
     *     nullable=true
     * )
     */
    public $traveled1Year;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled2_country",
     *     nullable=true
     * )
     */
    public $traveled2Country;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled2_city",
     *     nullable=true
     * )
     */
    public $traveled2City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled2_year",
     *     nullable=true
     * )
     */
    public $traveled2Year;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled3_country",
     *     nullable=true
     * )
     */
    public $traveled3Country;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled3_city",
     *     nullable=true
     * )
     */
    public $traveled3City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled3_year",
     *     nullable=true
     * )
     */
    public $traveled3Year;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled4_country",
     *     nullable=true
     * )
     */
    public $traveled4Country;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled4_city",
     *     nullable=true
     * )
     */
    public $traveled4City;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="traveled4_year",
     *     nullable=true
     * )
     */
    public $traveled4Year;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $personality;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $lookingFor;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $miscellaneous;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $sexInterests;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $sexToys;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $databaseId;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $chatStyle;

    /**
     * @ORM\Column(
     *     type="smallint",
     *     nullable=true
     * )
     */
    public $virtualReceivedMessagesCount;

    /**
     * @ORM\Column(
     *     type="bigint"
     * )
     */
    public $virtualApprovedTime;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $approvedImagesCount;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isOnline;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Melixas"
     * )
     * @ORM\JoinColumn(
     *     name="melixas",
     *     referencedColumnName="__uuid",
     *     nullable=true
     * )
     * @var \App\Entity\Melixas
     */
    public $melixasNode;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\WiimaxxLink",
     *     mappedBy="wiimaxxNode"
     * )
     */
    public $links;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\WiimaxxVirtualTrackingLink",
     *     inversedBy="wiimaxxNode"
     * )
     * @ORM\JoinColumn(
     *     name="wiimaxx_virtual_tracking_link",
     *     referencedColumnName="__uuid"
     * )
     * @ApiFilter(
     *     ExistsFilter::class
     * )
     * @var \App\Entity\WiimaxxVirtualTrackingLink
     */
    public $virtualTrackingLinkNode;
}
