<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Exceptions\InvalidTransactionCurrency;
use MyBudget\Budget\Domain\Exceptions\TransactionOutsideBudgetRange;
use MyBudget\Budget\Domain\ValueObject\BudgetId;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

class Budget
{
    public const CURRENCY_PLN = 'PLN';
    public const DEFAULT_CURRENCY = self::CURRENCY_PLN;

    private readonly AbstractUid $id;

    /** @var Collection<int, Transaction> */
    private Collection $transactions;

    public function __construct(
        // private PlanConfiguration $planConfigurations,
        // private string $description,
        private DateTimeImmutable $dateFrom,
        private DateTimeImmutable $dateTo,
        private Currency $currency = new Currency(self::DEFAULT_CURRENCY)
    ) {
        $this->id = Uuid::v4();
        $this->transactions = new ArrayCollection();

        if ($dateFrom > $dateTo) {
            throw new InvalidArgumentException();
        }

    }

    public function getId(): AbstractUid
    {
        return $this->id;
    }

    public function getIncomesAmount(): Money
    {
        return $this->getAmount(TransactionType::INCOME);
    }

    public function getExpensesAmount(): Money
    {
        return $this->getAmount(TransactionType::EXPENSE);
    }

    public function getDateFrom(): DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    private function getAmount(TransactionType $transactionType, ?Category $category = null): Money
    {
        $incomesAmount = new Money(0, $this->currency);
        foreach ($this->transactions as $transaction) {
            if (
                $transaction->getType() == $transactionType
                && (null === $category || $category === $transaction->getCategory())
            ) {
                $incomesAmount = $incomesAmount->add($transaction->getAmount());
            }
        }

        return $incomesAmount;
    }

    public function addTransaction(Transaction $transaction): void
    {
        if ($transaction->getDate() < $this->dateFrom || $transaction->getDate() > $this->dateTo) {
            throw new TransactionOutsideBudgetRange();
        }

        if (!$transaction->hasExpectedCurrency($this->currency)) {
            throw new InvalidTransactionCurrency();
        }

        $this->transactions->add($transaction);
    }
}
