<?php

declare(strict_types=1);

namespace MyBudget\Shared\Domain\Repository;

use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @template T of object
 *
 * @extends IteratorAggregate<array-key, T>
 */
interface RepositoryInterface extends IteratorAggregate, Countable
{
    /**
     * @return Iterator<T>
     */
    public function getIterator(): Iterator;

    public function count(): int;

    /**
     * @return PaginatorInterface<T>|null
     */
    public function paginator(): ?PaginatorInterface;

    /**
     * @return static<T>
     */
    public function withPagination(int $page, int $itemsPerPage): static;

    /**
     * @return static<T>
     */
    public function withoutPagination(): static;
}
