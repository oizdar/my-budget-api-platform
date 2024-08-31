<?php

declare(strict_types=1);

namespace MyBudget\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

trait AggregateRootId
{

    public readonly AbstractUid $id;

    final public function __construct(?AbstractUid $value = null)
    {
        $this->id = $value ?? Uuid::v4();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
