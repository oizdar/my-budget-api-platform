<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use MyBudget\Budget\Infrastructure\ApiPlatform\Resource\BudgetResource;
use MyBudget\Shared\Application\Command\CommandBusInterface;
use DateTimeImmutable;
use Money\Currency;
use MyBudget\Budget\Application\Command\CreateBudgetCommand;
use MyBudget\Budget\Domain\Model\Budget;


final readonly class CreateBudgetProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): BudgetResource
    {
        //        Assert::isInstanceOf($data, BudgetResource::class);
        //
        //        Assert::notNull($data->name);
        //        Assert::notNull($data->description);
        //        Assert::notNull($data->author);
        //        Assert::notNull($data->content);
        //        Assert::notNull($data->price);

        $command = new CreateBudgetCommand(
            new DateTimeImmutable($data->dateFrom),
            new DateTimeImmutable($data->dateTo),
            new Currency($data->currency),
        );

        /** @var Budget $model */
        $model = $this->commandBus->dispatch($command);

        return BudgetResource::fromModel($model);
    }
}
