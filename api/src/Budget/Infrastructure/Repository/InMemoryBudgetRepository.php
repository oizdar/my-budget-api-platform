<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Shared\Infrastructure\InMemory\InMemoryRepository;

/**
 * @extends InMemoryRepository<Budget>
 */
class InMemoryBudgetRepository extends InMemoryRepository implements BudgetRepositoryInterface
{
    /**
     * @var Budget[]
     */
    private $budgets = [];

    public function save(Budget $budget): void
    {
        $this->budgets[(string)$budget->getBudgetUuid()->value] = $budget;
    }

    public function remove(Budget $budget): void
    {
        $this->isBudgetExists($budget->getBudgetUuid());

        unset($this->budgets[(string)$budget->getBudgetUuid()]);
    }

    private function isBudgetExists(BudgetUuid $uuid): void
    {
        if (!isset($this->budgets[(string)$uuid])) {
            throw new BudgetNotFoundException();
        }
    }


    public function findByBudgetUuid(BudgetUuid $budgetUuid): Budget
    {
        $this->isBudgetExists($budgetUuid);

        return $this->budgets[(string)$budgetUuid];

    }
}
