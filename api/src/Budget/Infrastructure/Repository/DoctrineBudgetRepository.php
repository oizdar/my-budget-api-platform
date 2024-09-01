<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use App\BookStore\Domain\Model\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Domain\ValueObject\BudgetId;
use MyBudget\Shared\Infrastructure\Doctrine\DoctrineRepository;

/**
 * @extends EntityRepository<Budget>
 */
class DoctrineBudgetRepository extends DoctrineRepository implements BudgetRepositoryInterface
{
    private const ENTITY_CLASS = Budget::class;
    private const ALIAS = 'budget';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Budget $budget): void
    {
        $this->em->persist($budget);
        $this->em->flush();
    }

    public function getByBudgetId(BudgetId $budgetId): Budget
    {
        $queryBuilder = $this->em->createQueryBuilder();

        $queryBuilder->select('budget')
            ->from(Budget::class, 'budget')
            ->where('budget.budgetId = :budgetId')
            ->setParameter(':budgetId', $budgetId);

        $query = $queryBuilder->getQuery();
        try {
            $budget = $query->getSingleResult();
            assert($budget instanceof Budget);

            return $budget;
        } catch (NoResultException|NonUniqueResultException) {
            throw new BudgetNotFoundException();
        }
    }

    public function remove(Budget $budget): void
    {
        $this->em->remove($budget);
        $this->em->flush();
    }
}
