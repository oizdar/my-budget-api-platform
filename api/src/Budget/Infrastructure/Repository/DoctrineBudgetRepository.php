<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NoResultException;
use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;

class DoctrineBudgetRepository implements BudgetRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @var Budget[]
     */
    private $budgets = [];

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
            $cart = $query->getSingleResult();
            assert($cart instanceof Budget);

            return $cart;
        } catch (NoResultException) {
            throw new BudgetNotFoundException();
        }
    }

    /**
     * @throws ORMException
     */
    public function remove(int $id): void
    {
        $budget = $this->get($id);
        $this->entityManager->remove($budget);
    }
}
