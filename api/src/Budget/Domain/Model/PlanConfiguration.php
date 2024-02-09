<?php

namespace MyBudget\Budget\Domain\Model;

class PlanConfiguration
{
    public function __construct(
        private int $id,
        /** @var PlanConfigurationItem[] */
        private array $planConfigurationItems,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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
