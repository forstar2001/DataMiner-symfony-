<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

use App\Entity\Traits as Traits;

/**
 * @ORM\Entity(
 *     repositoryClass="App\Repository\WiimaxxLinkRepository"
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
 *     routePrefix="/node/wiimaxx/link"
 * )
 */
class WiimaxxLink
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
    public $fileId;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isPublic;

    /**
     * @ORM\Column(
     *     type="simple_array",
     *     nullable=true
     * )
     */
    public $allowedTo;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isVerified;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isGallery;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isProfile;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $verifiedByUsername;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $verifiedById;

    /**
     * @ORM\Column(
     *     type="bigint"
     * )
     */
    public $verifiedDate;

    /**
     * @ORM\Column(
     *     type="string"
     * )
     */
    public $ownerId;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $url;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $originalUrl;

    /**
     * @ORM\Column(
     *     type="string",
     *     unique=true
     * )
     */
    public $privateUrl;

    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     */
    public $isAllowedToRequestor;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     nullable=true
     * )
     */
    public $isHidden;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Wiimaxx",
     *     inversedBy="links"
     * )
     * @ORM\JoinColumn(
     *     name="wiimaxx",
     *     referencedColumnName="__uuid"
     * )
     */
    public $wiimaxxNode;
}
