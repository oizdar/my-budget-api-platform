<?php

namespace MyBudget\Budget\Domain\Model;

use DateTimeImmutable;
use MyBudget\Budget\Domain\Enums\BudgetGoal;

class Budget
{
    public function __construct(
        private readonly int $id,
        /** @var PlanConfiguration[] */
        private array $planConfigurations,
        private BudgetGoal $budgetGoal,
        private string $description,
        private DateTimeImmutable $dateTo,
        private DateTimeImmutable $dateFrom,
        /** @var Transaction[] */
        private array $transactions,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getPlanConfigurations(): array
    {
        return $this->planConfigurations;
    }

    public function getBudgetGoal(): BudgetGoal
    {
        return $this->budgetGoal;
    }
}