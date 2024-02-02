<?php

namespace MyBudget\Budget\Domain\Model;

class Category
{
    public function __construct(
        private int $id,
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
