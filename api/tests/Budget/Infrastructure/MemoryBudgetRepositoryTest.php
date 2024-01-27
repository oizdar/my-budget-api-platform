<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Budget\Infrastructure\Repository\MemoryBudgetRepository;
use MyBudget\Tests\Budget\Infrastructure\BudgetRepositoryTest;
use Override;

class MemoryBudgetRepositoryTest extends BudgetRepositoryTest
{

    protected function createRepository(): BudgetRepository
    {
        return new MemoryBudgetRepository();
    }
}
