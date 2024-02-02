<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;

class Transaction
{
    public function __construct(
        private int $id,
        private readonly TransactionType $type,
        private readonly Money $amount,
        private readonly DateTimeImmutable $date,
        private readonly ?Category $category = null,
        private readonly string $comment = '',
    ) {
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
}
