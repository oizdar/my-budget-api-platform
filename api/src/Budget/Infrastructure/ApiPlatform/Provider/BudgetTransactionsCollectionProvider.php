<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use ArrayIterator;
use MyBudget\Budget\Application\Query\FindBudgetTransactionsQuery;
use MyBudget\Budget\Infrastructure\ApiPlatform\Resource\BudgetResource;
use MyBudget\Budget\Infrastructure\ApiPlatform\Resource\TransactionResource;
use MyBudget\Shared\Application\Query\QueryBusInterface;
use MyBudget\Shared\Infrastructure\ApiPlatform\State\Paginator;

/**
 * @implements ProviderInterface<BudgetResource>
 */
final readonly class BudgetTransactionsCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return Paginator<BudgetResource>|BudgetResource
     * @return BudgetResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {

        if ($this->pagination->isEnabled($operation, $context)) {
            //todo: handle paggination
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }
ray($uriVariables, $context);
        $models = $this->queryBus->ask(new FindBudgetTransactionsQuery());

        $resources = [];
        foreach ($models as $model) {
            $resources[] = TransactionResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new ArrayIterator($resources),
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
