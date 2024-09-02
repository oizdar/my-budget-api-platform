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
    private const EXAMPLE_NAME_STRING = 'Example name';
    public function testEmptyBudget(): void
    {
        $budget = new Budget(
            self::EXAMPLE_NAME_STRING,
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::DEFAULT_CURRENCY),
        );

        $this->assertEquals(new Money(0, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getExpensesAmount());
        $this->assertEquals(new Money(0, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getIncomesAmount());
    }

    public function testBudgetAddTransactions(): void
    {
        $budget = new Budget(
            self::EXAMPLE_NAME_STRING,
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::DEFAULT_CURRENCY),
        );

        $category = new Category(1, 'Inne');
        $budget->addTransaction(
            new Transaction(
                1,
                TransactionType::INCOME,
                new Money(1000, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-01'),
                $category
            )
        );
        $budget->addTransaction(
            new Transaction(
                2,
                TransactionType::INCOME,
                new Money(1200, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-02'),
                $category
            )
        );

        $budget->addTransaction(
            new Transaction(
                3,
                TransactionType::EXPENSE,
                new Money(500, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-30'),
                $category
            )
        );
        $budget->addTransaction(
            new Transaction(
                4,
                TransactionType::EXPENSE,
                new Money(600, new Currency(Budget::DEFAULT_CURRENCY)),
                new DateTimeImmutable('2021-01-31'),
                $category
            )
        );

        $this->assertEquals(new Money(1100, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getExpensesAmount());
        $this->assertEquals(new Money(2200, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getIncomesAmount());
    }
}
