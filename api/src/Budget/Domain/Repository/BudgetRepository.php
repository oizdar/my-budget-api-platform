<?php

namespace MyBudget\Budget\Domain\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;

interface BudgetRepository
{
    public function add(Budget $budget): void;

    /**
     * @throws BudgetNotFoundException
     */
    public function get(int $id): Budget;

    /**
     * @throws BudgetNotFoundException
     */
    public function remove(int $id): void;
}