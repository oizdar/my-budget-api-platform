<?php

namespace MyBudget\Budget\Domain\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\ValueObject\BudgetId;
use MyBudget\Shared\Domain\Repository\RepositoryInterface;

interface BudgetRepositoryInterface extends RepositoryInterface
{
    public function save(Budget $budget): void;

    /**
     * @throws BudgetNotFoundException
     */
    public function getByBudgetId(BudgetId $uuid): Budget;

    /**
     * @throws BudgetNotFoundException
     */
    public function remove(Budget $budget): void;
}
