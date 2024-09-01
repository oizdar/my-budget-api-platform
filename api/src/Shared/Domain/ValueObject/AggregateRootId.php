<?php

declare(strict_types=1);

namespace MyBudget\Shared\Domain\ValueObject;

use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

trait AggregateRootId
{

    public readonly AbstractUid $uuid;

    final public function __construct(?AbstractUid $value = null)
    {
        $this->uuid = $value ?? Uuid::v4();
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
