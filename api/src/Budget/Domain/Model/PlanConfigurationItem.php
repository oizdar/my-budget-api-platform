<?php

namespace MyBudget\Budget\Domain\Model;

use Money\Money;

class PlanConfigurationItem
{
    public function __construct(
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
