<?php

declare(strict_types=1);

namespace MyBudget\Shared\Infrastructure\Symfony\Messenger;

use MyBudget\Shared\Application\Query\QueryBusInterface;
use MyBudget\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function ask(QueryInterface $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {
            /** @var array{0: Throwable} $exceptions */
            $exceptions = $e->getNestedExceptions();

            throw $exceptions[0];
        }
    }
}
