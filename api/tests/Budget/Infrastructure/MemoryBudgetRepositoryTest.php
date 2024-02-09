<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Budget\Infrastructure\Repository\MemoryBudgetRepository;

class MemoryBudgetRepositoryTest extends BudgetRepositoryTest
{
    protected function createRepository(): BudgetRepository
    {
        return static::getContainer()->get(MemoryBudgetRepository::class);
    }
}
