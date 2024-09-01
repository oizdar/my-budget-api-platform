<?php

declare(strict_types=1);

namespace MyBudget\Budget\Domain\ValueObject;

use MyBudget\Shared\Domain\ValueObject\AggregateRootId;
use Stringable;

final class BudgetId implements Stringable
{
    use AggregateRootId;
}
