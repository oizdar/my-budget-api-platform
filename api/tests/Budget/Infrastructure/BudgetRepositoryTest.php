<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use DateTimeImmutable;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BudgetRepositoryTest extends KernelTestCase
{
    private BudgetRepository $repository;

    abstract protected function createRepository(): BudgetRepository;

    protected function setUp(): void
    {
        $this->repository = $this->createRepository();
    }

    protected function flush()
    {
        // in-memory doesn't have flush, handle when add db repository implementation
    }

    public function testAddAndGetBudgetSuccessfully()
    {
        $budget = new Budget(
            1,
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            []
        );
        $this->repository->add($budget);
        $this->flush();

        $this->repository->get(1);
        $expected = new Budget(
            1,
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            []
        );

        $this->assertEquals(1, $budget->getId());
    }
}
