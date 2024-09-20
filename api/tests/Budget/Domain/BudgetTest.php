<?php

namespace MyBudget\Tests\Budget\Domain;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\BudgetStatus;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Exceptions\InvalidTransactionCurrency;
use MyBudget\Budget\Domain\Exceptions\TransactionOutsideBudgetRange;
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
        $this->assertEquals(BudgetStatus::DRAFT, $budget->getStatus());
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $budget->getCreatedAt()->format('Y-m-d'));
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $budget->getUpdatedAt()->format('Y-m-d'));
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

        $transaction1 = new Transaction(
            TransactionType::INCOME,
            new Money(1000, new Currency(Budget::DEFAULT_CURRENCY)),
            new DateTimeImmutable('2021-01-01'),
            $category
        );
        $transaction2 = new Transaction(
            TransactionType::INCOME,
            new Money(1200, new Currency(Budget::DEFAULT_CURRENCY)),
            new DateTimeImmutable('2021-01-15'),
            $category
        );

        $transaction3 = new Transaction(
            TransactionType::EXPENSE,
            new Money(500, new Currency(Budget::DEFAULT_CURRENCY)),
            new DateTimeImmutable('2021-01-30'),
            $category
        );

        $transaction4 = new Transaction(
            TransactionType::EXPENSE,
            new Money(600, new Currency(Budget::DEFAULT_CURRENCY)),
            new DateTimeImmutable('2021-01-31'),
            $category
        );

        $budget->addTransaction($transaction1);
        $budget->addTransaction($transaction2);
        $budget->addTransaction($transaction3);
        $budget->addTransaction($transaction4);


        $this->assertEquals(new Money(1100, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getExpensesAmount());
        $this->assertEquals(new Money(2200, new Currency(Budget::DEFAULT_CURRENCY)), $budget->getIncomesAmount());
        $this->assertEquals(BudgetStatus::DRAFT, $budget->getStatus());
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $budget->getCreatedAt()->format('Y-m-d'));
        $this->assertEquals((new DateTimeImmutable())->format('Y-m-d'), $budget->getUpdatedAt()->format('Y-m-d'));
    }

    public function testCannotAddTransactionsToBudgetWithOtherCurrency(): void
    {
        $this->expectException(InvalidTransactionCurrency::class);

        $budget = new Budget(
            self::EXAMPLE_NAME_STRING,
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::CURRENCY_PLN),
        );

        $category = new Category(1, 'Inne');

        $transaction1 = new Transaction(
            TransactionType::INCOME,
            new Money(1000, new Currency(Budget::CURRENCY_EUR)),
            new DateTimeImmutable('2021-01-01'),
            $category
        );

        $budget->addTransaction($transaction1);
    }


    private function provideDateRanges(): array
    {
        return [
            [
                new DateTimeImmutable('2021-01-01'),
                new DateTimeImmutable('2021-01-31'),
                new DateTimeImmutable('2021-02-01'),
            ],
            [
                new DateTimeImmutable('2021-01-01'),
                new DateTimeImmutable('2021-12-31'),
                new DateTimeImmutable('2020-12-31 23:59:59'),
            ],
        ];
    }

    /**
     * @dataProvider provideDateRanges
     */
    public function testCannotAddTransactionsToBudgetWithDateOutsideBudgetDateRange(
        DateTimeImmutable $rangeFrom,
        DateTimeImmutable $rangeTo,
        DateTimeImmutable $transactionOutsideRange
    ): void {
        $this->expectException(TransactionOutsideBudgetRange::class);

        $budget = new Budget(
            self::EXAMPLE_NAME_STRING,
            new DateTimeImmutable('2021-01-01'),
            new DateTimeImmutable('2021-01-31'),
            new Currency(Budget::CURRENCY_PLN),
        );

        $category = new Category(1, 'Inne');

        $transaction1 = new Transaction(
            TransactionType::INCOME,
            new Money(1000, new Currency(Budget::CURRENCY_EUR)),
            new DateTimeImmutable('2021-02-01'),
            $category
        );

        $budget->addTransaction($transaction1);
    }
}
