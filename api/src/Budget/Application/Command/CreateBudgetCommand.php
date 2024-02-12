<?php

declare(strict_types=1);

namespace MyBudget\Budget\Application\Command;

use DateTimeImmutable;
use Money\Currency;

final readonly class CreateBudgetCommand
{
    public function __construct(
        private DateTimeImmutable $dateFrom,
        private DateTimeImmutable $dateTo,
        private Currency $currency,
    ) {
    }
}
