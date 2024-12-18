<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Money\Currency;
use MyBudget\Budget\Domain\Enum\BudgetStatus;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Budget\Infrastructure\ApiPlatform\Processor\CreateBudgetProcessor;
use MyBudget\Budget\Infrastructure\ApiPlatform\Provider\BudgetCollectionProvider;
use MyBudget\Budget\Infrastructure\ApiPlatform\Provider\BudgetProvider;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Budget',
    operations: [
        /**
         * Queries
         */
//
//        // commands
//        new Post(
//            '/books/anonymize.{_format}',
//            status: 202,
//            openapiContext: ['summary' => 'Anonymize author of every Book resources.'],
//            input: AnonymizeBooksCommand::class,
//            output: false,
//            processor: AnonymizeBooksProcessor::class,
//        ),
//        new Post(
//            '/books/{id}/discount.{_format}',
//            openapiContext: ['summary' => 'Apply a discount percentage on a Book resource.'],
//            input: DiscountBookPayload::class,
//            provider: BookItemProvider::class,
//            processor: DiscountBookProcessor::class,
//        ),
//
        /**
         * Basic crud
         */
        new GetCollection(
//            filters: [AuthorFilter::class],
            provider: BudgetCollectionProvider::class,
        ),
        new Get(
            provider: BudgetProvider::class,
        ),
        new Post(
            validationContext: ['groups' => ['create']],
            processor: CreateBudgetProcessor::class,
        ),
//        new Put(
//            provider: BookItemProvider::class,
//            processor: UpdateBookProcessor::class,
//            extraProperties: ['standard_put' => true],
//        ),
//        new Patch(
//            provider: BookItemProvider::class,
//            processor: UpdateBookProcessor::class,
//        ),
//        new Delete(
//            provider: BookItemProvider::class,
//            processor: DeleteBookProcessor::class,
//        ),
    ],
)]
final class BudgetResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?BudgetUuid $budgetUuid = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 3, max: 150, groups: ['create'])]
        public ?string $name = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Date(groups: ['create', 'Default'])]
        public ?string $dateFrom = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Date(groups: ['create', 'Default'])]
        public ?string $dateTo = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?Currency $currency = null,

        #[ApiProperty(readable: true, writable: false)]
        public ?BudgetStatus $status = null,

        public ?array $transactions = null,
    ) {
    }

    public static function fromModel(Budget $budget): static
    {
        return new self(
            $budget->getBudgetUuid(),
            $budget->getName(),
            $budget->getDateFrom()->format('Y-m-d'),
            $budget->getDateTo()->format('Y-m-d'),
            $budget->getCurrency(),
            $budget->getStatus(),
        );
    }
}
