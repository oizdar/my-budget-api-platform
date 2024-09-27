<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Shared\Application\Query\QueryHandlerInterface;

final readonly class FindBudgetTransactionsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BudgetRepositoryInterface $budgetRepository)
    {
    }

    public function __invoke(FindBudgetQuery $query): ?Budget
    {
        return $this->budgetRepository->findByBudgetUuid($query->budgetUuid);
    }
}
