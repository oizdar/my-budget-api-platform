<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Infrastructure\Repository\InMemoryBudgetRepository;

class MemoryBudgetRepositoryTest extends BudgetRepositoryTest
{
    protected function createRepository(): BudgetRepositoryInterface
    {
        return static::getContainer()->get(InMemoryBudgetRepository::class);
    }
}
