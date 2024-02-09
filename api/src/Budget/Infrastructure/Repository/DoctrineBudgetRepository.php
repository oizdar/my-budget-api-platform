<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepository;

/**
 * @extends EntityRepository<Budget>
 */
class DoctrineBudgetRepository extends EntityRepository implements BudgetRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        /** @var ClassMetadata<Budget> $classMetaData */
        $classMetaData = $em->getClassMetadata(Budget::class);
        parent::__construct($em, $classMetaData);
    }

    public function add(Budget $budget): void
    {
        $this->getEntityManager()->persist($budget);
    }

    public function get(int $id): Budget
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

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
        $this->getEntityManager()->remove($budget);
    }
}
