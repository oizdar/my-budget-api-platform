<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Query;

use DateTimeImmutable;
use MyBudget\Shared\Application\Query\QueryInterface;

final readonly class FindBudgetsQuery implements QueryInterface
{
    public function __construct(
        public ?DateTimeImmutable $dateFrom = null,
        public ?DateTimeImmutable $dateTo = null,
        public ?int $page = null,
        public ?int $itemsPerPage = null,
    ) {
    }
}
