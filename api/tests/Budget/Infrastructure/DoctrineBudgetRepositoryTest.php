<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Tests\DoctrineTestTrait;

class DoctrineBudgetRepositoryTest extends BudgetRepositoryTest
{
    use DoctrineTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        static::truncateTableCascade('budget');
    }

    protected function createRepository(): BudgetRepository
    {
        return static::$entityManager->getRepository(Budget::class);
    }
}
