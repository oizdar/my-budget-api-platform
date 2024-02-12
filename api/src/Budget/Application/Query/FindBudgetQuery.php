<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

final readonly class FindBudgetQuery
{
    public function __construct(
        public int $id,
    ) {
    }
}
