<?php

namespace MyBudget\Budget\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MyBudget\Budget\Domain\Exceptions\BudgetNotFoundException;
use MyBudget\Budget\Domain\Model\Budget;
use MyBudget\Budget\Domain\Repository\BudgetRepositoryInterface;
use MyBudget\Budget\Domain\ValueObject\BudgetUuid;
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

    public function findByBudgetUuid(BudgetUuid $budgetUuid): Budget
    {
        $queryBuilder = $this->em->createQueryBuilder();

        $queryBuilder->select( self::ALIAS)
            ->from(self::ENTITY_CLASS, self::ALIAS)
            ->where(self::ALIAS . '.budgetUuid.uuid = :budgetUuid')
            ->setParameter('budgetUuid', $budgetUuid->uuid);

        try {
            $budget = $queryBuilder->getQuery()->getSingleResult();
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
