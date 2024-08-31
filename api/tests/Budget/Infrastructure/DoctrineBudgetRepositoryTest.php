<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Tests\DoctrineTestTrait;

class DoctrineBudgetRepositoryTest extends BudgetRepositoryTest
{
    use DoctrineTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        static::truncateTableCascade('budget');
    }

    protected function createRepository(): BudgetRepositoryInterface
    {
        return static::$entityManager->getRepository(Budget::class);
    }
}
