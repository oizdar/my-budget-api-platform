<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;

class MemoryBudgetRepository implements BudgetRepository
{
    /**
     * @var Budget[]
     */
    private $budgets = [];

    public function add(Budget $budget): void
    {
        $this->budgets[$budget->getId()] = $budget;
    }

    public function get(int $id): Budget
    {
        $this->isBudgetExists($id);

        return $this->budgets[$id];
    }

    public function remove(int $id): void
    {
        $this->isBudgetExists($id);
        unset($this->budgets[$id]);
    }

    private function isBudgetExists(int $id): void
    {
        if (!isset($this->budgets[$id])) {
            throw new BudgetNotFoundException();
        }
    }
}
