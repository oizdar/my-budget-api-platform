<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;

class DoctrineBudgetRepository implements BudgetRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function add(Budget $budget): void
    {
        $this->entityManager->persist($budget);
    }

    public function get(int $id): Budget
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('budget')
            ->from(Budget::class, 'budget')
            ->where('budget.id = :id')
            ->setParameter(':id', $id);

        $query = $queryBuilder->getQuery();
        try {
            $budget = $query->getSingleResult();
            assert($budget instanceof Budget);

            return $budget;
        } catch (NoResultException|NonUniqueResultException) {
            throw new BudgetNotFoundException();
        }
    }

    public function remove(int $id): void
    {
        $budget = $this->get($id);
        $this->entityManager->remove($budget);
    }
}
