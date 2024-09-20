<?php

declare(strict_types=1);

namespace MyBudget\Budget\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use DomainException;
use InvalidArgumentException;
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
        Assert::notNull($data->name);
        Assert::lengthBetween($data->name, 3, 150);
        Assert::notNull($data->dateFrom);
        Assert::notNull($data->dateTo);
        Assert::notNull($data->currency);

        $command = new CreateBudgetCommand(
            $data->name,
            new DateTimeImmutable($data->dateFrom),
            new DateTimeImmutable($data->dateTo),
            $data->currency,
        );

        try {
            /** @var Budget $model */
            $model = $this->commandBus->dispatch($command);
        } catch (DomainException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }


        return BudgetResource::fromModel($model);
    }
}
