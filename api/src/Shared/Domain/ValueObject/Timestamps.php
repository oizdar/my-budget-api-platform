<?php

declare(strict_types=1);

namespace MyBudget\Shared\Domain\ValueObject;

use DateTimeImmutable;

class Timestamps
{
    private DateTimeImmutable $createdAt;

    private ?DateTimeImmutable $updatedAt;

    public function __construct()
    {
        // Automatically set the creation time when the object is instantiated.
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function update(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}

