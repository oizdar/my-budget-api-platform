<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeImmutable;
use Money\Currency;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\ValueObject\BudgetId;
use MyBudget\Budget\Infrastructure\ApiPlatform\Processor\CreateBudgetProcessor;
use MyBudget\Budget\Infrastructure\ApiPlatform\Provider\BudgetCollectionProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Budget',
    operations: [
        /**
         * Queries
         */
//        new GetCollection(
//            '/budgets.{_format}',
//            openapiContext: ['summary' => 'Find cheapest Book resources.'],
//            paginationEnabled: false,
//            provider: BudgetCollectionProvider::class,
//        ),
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
//        new Get(
//            provider: BudgetItemProvider::class,
//        ),
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
        public ?BudgetId $budgetId = null,

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
    ) {
    }

    public static function fromModel(Budget $budget): static
    {
        return new self(
            $budget->getBudgetId(),
            $budget->getName(),
            $budget->getDateFrom()->format('Y-m-d'),
            $budget->getDateTo()->format('Y-m-d'),
            $budget->getCurrency(),
        );
    }
}
