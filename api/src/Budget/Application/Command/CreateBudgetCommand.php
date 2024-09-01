<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Command;

use DateTimeImmutable;
use Money\Currency;
use MyBudget\Shared\Application\Command\CommandInterface;

final readonly class CreateBudgetCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public DateTimeImmutable $dateFrom,
        public DateTimeImmutable $dateTo,
        public Currency $currency,
    ) {
    }
}
