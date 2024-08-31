<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BudgetRepositoryTest extends KernelTestCase
{
    private BudgetRepositoryInterface $repository;

    abstract protected function createRepository(): BudgetRepositoryInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createRepository();
    }

    protected function flush()
    {
        // in-memory doesn't need flush, to handle when adding db repository implementation
    }

    public function testAddAndGetBudgetSuccessfully()
    {
        $budget = new Budget(
            1,
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
        );
        $this->repository->create($budget);

        $this->flush();

        $this->repository->get(1);
        $expected = new Budget(
            1,
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
        );

        $this->assertEquals(1, $budget->getId());
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getIncomesAmount());
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getExpensesAmount());
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getExpensesAmount());
    }
}
