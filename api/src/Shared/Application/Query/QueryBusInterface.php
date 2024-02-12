<?php

declare(strict_types=1);

namespace MyBudget\Shared\Application\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
