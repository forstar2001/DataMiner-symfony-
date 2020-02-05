<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

use DateTimeInterface;

use DateTimeImmutable;
use DateTimeZone;

trait LifecycleEventsTrait
{
    /**
     * @ORM\Column(
     *     type="datetime_immutable"
     * )
     */
    protected $__createdAt;

    /**
     * @ORM\Column(
     *     type="datetime_immutable"
     * )
     */
    protected $__updatedAt;

    public function getCreatedAt(): ?DateTimeInterface // TODO: fix name
    {
        return $this->__createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt(): void // TODO: fix name
    {
        $this->__createdAt = new DateTimeImmutable(
            'now',
            new DateTimeZone(
                'UTC'
            )
        );
    }

    public function getUpdatedAt(): ?DateTimeInterface // TODO: fix name
    {
        return $this->__updatedAt;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt(): void // TODO: fix name
    {
        $this->__updatedAt = new DateTimeImmutable(
            'now',
            new DateTimeZone(
                'UTC'
            )
        );
    }
}
