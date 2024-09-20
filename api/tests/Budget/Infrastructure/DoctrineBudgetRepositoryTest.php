<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use DateTimeImmutable;
use Money\Currency;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Infrastructure\Repository\DoctrineBudgetRepository;
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
        return static::getContainer()->get(DoctrineBudgetRepository::class);
    }

    public function testBudgetTimestamps(): void
    {
        $budget = new Budget(
            'exampleBudget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::DEFAULT_CURRENCY),
        );
        $repository = $this->createRepository();
        $repository->save($budget);

        $budgetFromDB = $repository->findByBudgetUuid($budget->getBudgetUuid());

        $this->assertNotNull($budgetFromDB->getCreatedAt());
        $this->assertNotNull($budgetFromDB->getUpdatedAt());

        $dateBeforeUpdate = $budgetFromDB->getUpdatedAt();

        $budget->setActive();
        $repository->save($budget);

        $this->assertTrue($dateBeforeUpdate < $budgetFromDB->getUpdatedAt());
    }

}
