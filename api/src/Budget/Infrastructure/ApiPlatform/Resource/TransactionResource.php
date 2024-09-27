<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Money\Money;
use MyBudget\Budget\Domain\Enum\TransactionType;
use MyBudget\Budget\Domain\Model\Category;
use MyBudget\Budget\Domain\Model\Transaction;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Budget\Domain\ValueObject\TransactionUuid;
use MyBudget\Budget\Infrastructure\ApiPlatform\Provider\BudgetTransactionsCollectionProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Transaction',
    operations: [
        /**
         * Queries
         */
        new GetCollection(
            'budgets/{budgetUuid}/transactions.{_format}',
            openapiContext: ['summary' => 'Get transactions of Given Budget'],
            paginationEnabled: true,
            provider: BudgetTransactionsCollectionProvider::class,
        ),
        new Get(
            uriTemplate: '/transactions/{transactionUuid}.{_format}',
            openapiContext: ['summary' => 'Get specific transaction by UUID'],
        ),
    ],
)]
final class TransactionResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?TransactionUuid $transactionUuid = null,

        #[ApiProperty(readable: false, writable: false)]
        public ?BudgetUuid $budgetUuid = null,

        #[Assert\NotNull(groups: ['create', 'Default'])]
        public ?TransactionType $type = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Date(groups: ['create', 'Default'])]
        public ?string $date = null,

        #[Assert\NotNull(groups: ['create', 'Default'])]
        public ?Money $amount = null,

        #[Assert\NotNull(groups: ['create', 'Default'])]
        public ?Category $category = null,

        #[ApiProperty(readable: true, writable: false)]
        public ?string $comment = null,
    ) {
    }

    public static function fromModel(Transaction $transaction): static
    {
        return new self(
            $transaction->getTransactionUuid(),
            $transaction->getBudget()->getBudgetUuid(),
            $transaction->getType(),
            $transaction->getDate()->format('Y-m-d H:i:s'),
            $transaction->getAmount(),
            $transaction->getCategory(),
            $transaction->getComment(),
        );
    }
}
