<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use Doctrine\ORM\EntityManager;
use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Budget\Infrastructure\Repository\DoctrineBudgetRepository;

class DoctrineBudgetRepositoryTest extends BudgetRepositoryTest
{
    protected function flush(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    protected function setUp(): void
    {
        //        ConnectionManager::dropAndCreateDatabase();
        //        $connection = ConnectionManager::createConnection();
        //        $xmlMappedClasses = [Cart::class, Item::class];
        //        $this->entityManager = EntityManagerFactory::createEntityManager($connection, $xmlMappedClasses, []);
        parent::setUp();
    }

    protected function createRepository(): BudgetRepository
    {
        return new DoctrineBudgetRepository($this->getContainer()->get('doctrine.orm.entity_manager'));
    }
}
