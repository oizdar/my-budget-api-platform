<?php

namespace MyBudget\Budget\Domain\Model;

use MyBudget\Budget\Domain\Enums\TransactionType;

class Category
{
    public function __construct(
        private readonly int $id,
        private string $name,
        private string $description,
        private TransactionType $type,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): TransactionType
    {
        return $this->type;
    }
}
