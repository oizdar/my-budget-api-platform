<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use MyBudget\Budget\Application\Command\CreateBudgetCommand;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Infrastructure\ApiPlatform\Resource\BudgetResource;
use MyBudget\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

/**
 * @implements ProcessorInterface<BudgetResource, BudgetResource>
 */
final readonly class CreateBudgetProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BudgetResource
    {
        /* @var BudgetResource $data */
        Assert::isInstanceOf($data, BudgetResource::class);
        Assert::notNull($data->dateFrom);
        Assert::notNull($data->dateTo);
        Assert::notNull($data->currency);

        $command = new CreateBudgetCommand(
            $data->dateFrom,
            $data->dateTo,
            $data->currency,
        );

        /** @var Budget $model */
        $model = $this->commandBus->dispatch($command);

        return BudgetResource::fromModel($model);
    }
}
