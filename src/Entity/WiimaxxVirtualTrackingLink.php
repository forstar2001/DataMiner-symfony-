<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

use App\Entity\Traits as Traits;

/**
 * @ORM\Entity(
 *     repositoryClass="App\Repository\WiimaxxVirtualTrackingLinkRepository"
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
 *     routePrefix="/node/wiimaxx/virtual-tracking-link"
 * )
 */
class WiimaxxVirtualTrackingLink
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
     *     type="string"
     * )
     */
    public $siteId;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $contractorId;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $description;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $linkType;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $virtualId;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $countryCode;

    /**
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     */
    public $platform;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $publicAccessKey;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $afterRegisterLandTo;

    /**
     * @ORM\Column(
     *     type="smallint"
     * )
     */
    public $landingOverride;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Entity\Wiimaxx",
     *     mappedBy="virtualTrackingLink"
     * )
     * @ORM\JoinColumn(
     *     name="wiimaxx",
     *     referencedColumnName="__uuid",
     *     nullable=true
     * )
     *
     * @var Wiimaxx
     */
    public $wiimaxxNode;
}
