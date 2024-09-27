<?php

namespace MyBudget\Budget\Domain\Repository;

use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Model\Transaction;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Budget\Domain\ValueObject\TransactionUuid;
use MyBudget\Shared\Domain\Repository\RepositoryInterface;

interface TransactionsRepositoryInterface extends RepositoryInterface
{
    public function save(Transaction $budget): void;

    /**
     * @throws BudgetNotFoundException
     */
    public function findByBudgetUuid(BudgetUuid $budgetUuid): array;

    /**
     * @throws BudgetNotFoundException
     */
    public function remove(Transaction $budget): void;

    /**
     * @throws BudgetNotFoundException
     */
    public function findByTransactionUuid(TransactionUuid $budgetUuid): Transaction;
}
