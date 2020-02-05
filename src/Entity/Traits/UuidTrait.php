<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UuidTrait
{
    /**
     * @ORM\Column(
     *     type="guid",
     *     unique=true
     * )
     * @ORM\GeneratedValue(
     *     strategy="UUID"
     * )
     * @ORM\Id()
     */
    public $__uuid;
}
