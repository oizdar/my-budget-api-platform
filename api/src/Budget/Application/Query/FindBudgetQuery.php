<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Shared\Application\Query\QueryInterface;

final readonly class FindBudgetQuery implements QueryInterface
{
    public function __construct(
        public BudgetUuid $budgetUuid,
    ) {
    }
}
