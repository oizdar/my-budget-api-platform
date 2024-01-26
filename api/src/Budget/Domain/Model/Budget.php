<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;

class Budget
{
    public function __construct(
        private PlanConfiguration $planConfigurations,
        private string $description,
        private DateTimeImmutable $dateTo,
        private DateTimeImmutable $dateFrom,
        /** @var Transaction[] */
        private array $transactions,
    ) {
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateFrom(): DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function getDateTo(): DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getPlanConfigurations(): PlanConfiguration
    {
        return $this->planConfigurations;
    }

    public function getBudgetGoal(): string
    {
        return $this->budgetGoal;
    }
}
