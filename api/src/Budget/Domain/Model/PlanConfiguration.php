<?php

namespace MyBudget\Budget\Domain\Model;

use Money\Money;

class PlanConfiguration
{
    public function __construct(
        /** @var PlanConfigurationItem[] */
        private array $planConfigurationItems,
    ) {
    }

    public function addPlanItem(PlanConfigurationItem $planConfigurationItem): void
    {
        $this->planConfigurationItems[] = $planConfigurationItem;
    }

    public function getPlanConfigurationItems(): array
    {
        return $this->planConfigurationItems;
    }
}
