<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Command;

use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Shared\Application\Command\CommandHandlerInterface;

final readonly class CreateBudgetCommandHandler implements CommandHandlerInterface
{
    public function __construct(private BudgetRepositoryInterface $budgetRepository)
    {
    }

    public function __invoke(CreateBudgetCommand $command): Budget
    {
        $budget = new Budget(
            $command->dateFrom,
            $command->dateTo,
            $command->currency,
        );

        $this->budgetRepository->save($budget);

        return $budget;
    }
}
