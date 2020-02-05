<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;

use App\Entity\Traits as Traits;

/**
 * @ORM\Entity(
 *     repositoryClass="App\Repository\MelixasRepository"
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
 *     routePrefix="/node/melixas"
 * )
 */
class Melixas
{
    use Traits\UuidTrait;

    use Traits\LifecycleEventsTrait;

    use Traits\StatesTrait;

    use Traits\RawTrait;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $_id;

    /**
     * @ORM\Column(
     *     type="bigint",
     *     nullable=true
     * )
     */
    public $birthDay;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $country;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $gender;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $imageCount;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isEmailVerified;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isProfileVerified;

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
     *     type="string",
     *     unique=true
     * )
     */
    public $username;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isOnline;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isFavorited;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isFlirtSent;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $searchTopStopExpiresOn;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isNew;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $timezoneName;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Wiimaxx"
     * )
     * @ORM\JoinColumn(
     *     name="wiimaxx",
     *     referencedColumnName="__uuid"
     * )
     * @ApiFilter(
     *     ExistsFilter::class
     * )
     * @var \App\Entity\Wiimaxx
     */
    public $wiimaxxNode;
}
