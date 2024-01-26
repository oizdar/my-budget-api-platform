<?php

namespace MyBudget\Budget\Domain\Model;

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

    /**
     * @return PlanConfigurationItem[]
     */
    public function getPlanConfigurationItems(): array
    {
        return $this->planConfigurationItems;
    }
}
