<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use MyBudget\Budget\Application\Query\FindBudgetQuery;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
use MyBudget\Budget\Infrastructure\ApiPlatform\Resource\BudgetResource;
use MyBudget\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<BudgetResource>
 */
final readonly class BudgetProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?BudgetResource
    {
        /** @var string $uuid */
        $uuid = $uriVariables['budgetUuid'];

        /** @var Budget|null $model */
        $model = $this->queryBus->ask(new FindBudgetQuery(new BudgetUuid(Uuid::fromString($uuid))));

        return null !== $model ? BudgetResource::fromModel($model) : null;
    }
}
