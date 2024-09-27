<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Domain\Repository\TransactionsRepositoryInterface;
use MyBudget\Shared\Application\Query\QueryHandlerInterface;

final readonly class FindBudgetTransactionsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TransactionsRepositoryInterface $transactionsRepository)
    {
    }

    public function __invoke(FindBudgetTransactionsQuery $query): ?Budget
    {
        return $this->transactionsRepository->findByBudgetUuid($query->budgetUuid);
    }
}
