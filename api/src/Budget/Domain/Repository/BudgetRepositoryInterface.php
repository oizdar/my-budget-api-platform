<?php

namespace MyBudget\Budget\Domain\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Shared\Domain\Repository\RepositoryInterface;

interface BudgetRepositoryInterface extends RepositoryInterface
{
    public function save(Budget $budget): void;

    /**
     * @throws BudgetNotFoundException
     */
    public function get(int $id): Budget;

    /**
     * @throws BudgetNotFoundException
     */
    public function remove(Budget $budget): void;
}
