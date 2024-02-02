<?php

namespace MyBudget\Tests\Budget\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use MyBudget\Budget\Domain\Repository\BudgetRepository;
use MyBudget\Budget\Infrastructure\Repository\DoctrineBudgetRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DoctrineBudgetRepositoryTest extends BudgetRepositoryTest
{

    private EntityManagerInterface $entityManager;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $connection = static::getContainer();

        (new Application(static::$kernel))
            ->find('doctrine:database:create')
            ->run(new ArrayInput(['--if-not-exists' => true]), new NullOutput());

        (new Application(static::$kernel))
            ->find('doctrine:schema:update')
            ->run(new ArrayInput(['--force' => true]), new NullOutput());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);


        self::getContainer()->get(Connection::class)->executeStatement('TRUNCATE budget CASCADE');
    }

    protected function flush(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }


    protected function createRepository(): BudgetRepository
    {
        return self::getContainer()->get(DoctrineBudgetRepository::class);
    }
}
