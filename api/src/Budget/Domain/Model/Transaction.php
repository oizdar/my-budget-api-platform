<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\ValueObject\TransactionUuid;

class Transaction
{

    private readonly int $id;

    private readonly TransactionUuid $transactionUuid;

    private readonly Budget $budget;

    public function __construct(
        private readonly TransactionType $type,
        private readonly Money $amount,
        private readonly DateTimeImmutable $date,
        private readonly ?Category $category = null,
        private readonly ?string $comment = null,
    ) {
        $this->transactionUuid = new TransactionUuid();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTransactionUuid(): TransactionUuid
    {
        return $this->transactionUuid;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getType(): TransactionType
    {
        return $this->type;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function hasExpectedCurrency(Currency $currency): bool
    {
        return $this->amount->getCurrency()->equals($currency);
    }

    public function setBudget(Budget $budget): void
    {
        $this->budget = $budget;
    }

    public function getBudget(): Budget
    {
        return $this->budget;
    }
}
