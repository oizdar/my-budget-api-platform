<?php

namespace MyBudget\Tests\Budget\Domain;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Model\Category;
use MyBudget\Budget\Domain\Model\Transaction;
use PHPUnit\Framework\TestCase;

class BudgetTest extends TestCase
{
    public function testEmptyBudget(): void
    {
        $budget = new Budget(
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            []
        );

        $this->assertEquals(new Money(0, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getExpensesAmount());
        $this->assertEquals(new Money(0, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getIncomesAmount());
    }

    public function testBudgetAddTransactions(): void
    {
        $budget = new Budget(
            // new PlanConfiguration([]),
            // 'Empty budget',
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            []
        );

        $budget->addTransaction(
            new Transaction(
                TransactionType::INCOME,
                new Money(1000, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-01'),
                new Category('Inne')
            )
        );
        $budget->addTransaction(
            new Transaction(
                TransactionType::INCOME,
                new Money(1200, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-02'),
                new Category('Inne')
            )
        );

        $budget->addTransaction(
            new Transaction(
                TransactionType::EXPENSE,
                new Money(500, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-30'),
                new Category('Inne')
            )
        );
        $budget->addTransaction(
            new Transaction(
                TransactionType::EXPENSE,
                new Money(600, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-31'),
                new Category('Inne')
            )
        );

        $this->assertEquals(new Money(1100, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getExpensesAmount());
        $this->assertEquals(new Money(2200, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getIncomesAmount());
    }
}
