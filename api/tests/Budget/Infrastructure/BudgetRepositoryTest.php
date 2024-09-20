<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\BudgetStatus;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Infrastructure\Repository\DoctrineBudgetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

abstract class BudgetRepositoryTest extends KernelTestCase
{
    private const EXAMPLE_NAME_STRING = 'Example name';

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
            self::EXAMPLE_NAME_STRING,
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::DEFAULT_CURRENCY),
        );

        $this->repository->save($budget);
        $this->flush();

        $budget = $this->repository->findByBudgetUuid($budget->getBudgetUuid());

        if ($this->repository instanceof DoctrineBudgetRepository) {
            $this->assertNotNull($budget->getId());
        }

        $this->assertTrue(Uuid::isValid($budget->getBudgetUuid()->value));
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getIncomesAmount());
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getExpensesAmount());
        $this->assertEquals(new Money(0, new Currency('PLN')), $budget->getExpensesAmount());
        $this->assertEquals(BudgetStatus::DRAFT, $budget->getStatus());
    }
}
