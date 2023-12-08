<?php

namespace MyBudget\Budget\Domain\Model;

use Money\Money;

class PlanConfiguration
{
    public function __construct(
        private readonly int $id,
        private Category $category,
        private string $remarks,
        private Money $plannedAmount,
    ) {
    }

    public function update(Category $category, string $remarks, Money $plannedAmount): void
    {
        $this->category = $category;
        $this->remarks = $remarks;
        $this->plannedAmount = $plannedAmount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function getPlannedAmount(): Money
    {
        return $this->plannedAmount;
    }
}
