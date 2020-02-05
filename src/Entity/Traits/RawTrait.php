<?php

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;

trait RawTrait
{
    /**
     * @ORM\Column(
     *     type="object"
     * )
     * @ApiProperty(
     *     readable=false
     * )
     */
    public $__rawRecord;

    /**
     * @ORM\Column(
     *     type="object"
     * )
     * @ApiProperty(
     *     readable=false
     * )
     */
    public $__rawRequest;

    /**
     * @ORM\Column(
     *     type="object"
     * )
     * @ApiProperty(
     *     readable=false
     * )
     */
    public $__rawResponse;
}
