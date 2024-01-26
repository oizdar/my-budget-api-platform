<?php

namespace MyBudget\Budget\Domain\Model;

use MyBudget\Budget\Domain\Enum\TransactionType;

class Category
{
    public function __construct(
        private string $name,
        private string $description = '',
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
}
