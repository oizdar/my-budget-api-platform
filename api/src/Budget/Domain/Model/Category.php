<?php

namespace MyBudget\Budget\Domain\Model;

use MyBudget\Budget\Domain\Enum\TransactionType;

class Category
{
    public function __construct(
        private string $name,
        private string $description,
        private TransactionType $type,
    ) {
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
