<?php

namespace MyBudget\Budget\Domain\Model;

use Money\Money;

class Transaction
{
    public function __construct(
        private readonly int $id,
        private readonly Category $category,
        private readonly string $comment,
        private readonly \DateTimeImmutable $date,
        private readonly Money $amount,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
