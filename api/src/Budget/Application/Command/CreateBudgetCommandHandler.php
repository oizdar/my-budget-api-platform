<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Command;

use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Model\Category;
use MyBudget\Budget\Domain\Model\Transaction;
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
            $command->name,
            $command->dateFrom,
            $command->dateTo,
            $command->currency,
        );

        $category = new Category(1, 'Inne');
        $transaction = new Transaction(
            TransactionType::INCOME,
            new Money(1000, new Currency(Budget::DEFAULT_CURRENCY)),
            new DateTimeImmutable('2024-01-01'),
            $category
        );

        $budget->addTransaction($transaction);
        $this->budgetRepository->save($budget);

        return $budget;
    }
}
