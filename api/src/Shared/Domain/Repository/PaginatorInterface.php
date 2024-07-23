<?php

declare(strict_types=1);

namespace MyBudget\Shared\Domain\Repository;

use Countable;
use IteratorAggregate;

/**
 * @template T of object
 *
 * @extends IteratorAggregate<array-key, T>
 */
interface PaginatorInterface extends IteratorAggregate, Countable
{
    public function getCurrentPage(): int;

    public function getItemsPerPage(): int;

    public function getLastPage(): int;

    public function getTotalItems(): int;
}
