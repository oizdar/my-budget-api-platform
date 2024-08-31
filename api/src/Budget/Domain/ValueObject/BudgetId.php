<?php

declare(strict_types=1);

namespace MyBudget\Budget\Domain\ValueObject;

use Stringable;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

final class BudgetId implements Stringable
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
