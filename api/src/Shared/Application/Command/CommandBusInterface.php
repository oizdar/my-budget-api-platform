<?php

declare(strict_types=1);

namespace MyBudget\Shared\Application\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
