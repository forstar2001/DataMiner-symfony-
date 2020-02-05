<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

trait StatesTrait
{
    /**
     * @ORM\Column(
     *     type="boolean"
     * )
     * @ApiFilter(
     *     BooleanFilter::class
     * )
     */
    public $__isActive;
}
