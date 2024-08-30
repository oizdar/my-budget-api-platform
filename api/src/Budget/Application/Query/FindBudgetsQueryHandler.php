<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Shared\Application\Query\QueryHandlerInterface;

final readonly class FindBudgetsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private BudgetRepository $budgetRepository)
    {
    }

    public function __invoke(FindBudgetsQuery $query): BudgetRepository
    {
        $budgetRepository = $this->budgetRepository;

//        if (null !== $query->author) {
//            $bookRepository = $bookRepository->withAuthor($query->author);
//        }

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $budgetRepository = $budgetRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $budgetRepository;
    }
}