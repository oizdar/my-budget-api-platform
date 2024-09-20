<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\BudgetStatus;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Exceptions\BudgetStatusInvalidException;
use MyBudget\Budget\Domain\Exceptions\InvalidTransactionCurrency;
use MyBudget\Budget\Domain\Exceptions\TransactionOutsideBudgetRange;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Shared\Domain\ValueObject\Timestamps;
use Webmozart\Assert\Assert;

class Budget
{
    public const CURRENCY_PLN = 'PLN';
    public const DEFAULT_CURRENCY = self::CURRENCY_PLN;

    private readonly int $id;
    private readonly BudgetUuid $budgetUuid;

    private BudgetStatus $status;
    private Timestamps $timestamps;


    /** @var Collection<int, Transaction> */
    private Collection $transactions;

    public function __construct(
        // private PlanConfiguration $planConfigurations,
        private string $name,
        private DateTimeImmutable $dateFrom,
        private DateTimeImmutable $dateTo,
        private Currency $currency,
    ) {
        $this->budgetUuid = new BudgetUuid();
        $this->transactions = new ArrayCollection();
        $this->status = BudgetStatus::DRAFT;
        $this->timestamps = new Timestamps();

        Assert::lengthBetween($this->name, 3, 150);

        if ($dateFrom > $dateTo) {
            throw new InvalidArgumentException();
        }
    }

    public function preUpdate(): void
    {
        // Automatically update the updatedAt timestamp on entity updates.
        $this->timestamps->update();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBudgetUuid(): BudgetUuid
    {
        return $this->budgetUuid;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getStatus(): BudgetStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->timestamps->getCreatedAt();
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->timestamps->getUpdatedAt();
    }

    public function setActive()
    {
        if ($this->status !== BudgetStatus::DRAFT) {
            throw new BudgetStatusInvalidException();
        }

        $this->status = BudgetStatus::ACTIVE;
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
