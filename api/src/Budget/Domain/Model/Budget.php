<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Exceptions\InvalidTransactionCurrency;
use MyBudget\Budget\Domain\Exceptions\TransactionOutsideBudgetRange;

class Budget
{
    public const string CURRENCY_PLN = 'PLN';
    public const string DEFAULT_CURRENCY = self::CURRENCY_PLN;

    public function __construct(
        private PlanConfiguration $planConfigurations,
        private string $description,
        private DateTimeImmutable $dateFrom,
        private DateTimeImmutable $dateTo,
        /** @var Transaction[] */
        private array $transactions = [],
        private Currency $currency = new Currency(self::DEFAULT_CURRENCY)
    ) {
        if($dateFrom > $dateTo) {
            throw new InvalidArgumentException();
        }
    }

    public function getIncomesAmount(): Money
    {
        return $this->getAmount(TransactionType::INCOME);
    }

    public function getExpensesAmount(): Money
    {
        return $this->getAmount(TransactionType::EXPENSE);
    }

    private function getAmount(TransactionType $transactionType, ?Category $category = null): Money
    {
        $incomesAmount = new Money(0, $this->currency);
        foreach($this->transactions as $transaction) {
            if(
                $transaction->getType() == $transactionType
                && ($category === null || $category === $transaction->getCategory())
            ) {
                $incomesAmount = $incomesAmount->add($transaction->getAmount());
            }
        }

        return $incomesAmount;
    }

    public function addTransaction(Transaction $transaction): void
    {
        if($transaction->getDate() < $this->dateFrom || $transaction->getDate() > $this->dateTo) {
            throw new TransactionOutsideBudgetRange();
        }

        if(!$transaction->hasExpectedCurrency($this->currency)) {
            throw new InvalidTransactionCurrency();
        }

        $this->transactions[] = $transaction;
    }

}
