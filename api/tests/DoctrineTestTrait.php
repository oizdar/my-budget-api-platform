<?php

namespace MyBudget\Tests;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

trait DoctrineTestTrait
{
    protected static Connection $connection;
    protected static EntityManagerInterface $entityManager;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::$connection = static::getContainer()->get(Connection::class);
        static::$entityManager = static::getContainer()->get(EntityManagerInterface::class);

        static::cleanupDatabase();
    }

    public static function cleanupDatabase()
    {
        (new Application(KernelTestCase::$kernel))
            ->find('doctrine:database:create')
            ->run(new ArrayInput(['--if-not-exists' => true]), new NullOutput());

        (new Application(KernelTestCase::$kernel))
            ->find('doctrine:schema:update')
            ->run(new ArrayInput(['--force' => true]), new NullOutput());
    }

    public static function truncateTableCascade(string $tableName)
    {
        $stm = static::$connection->executeQuery(sprintf('TRUNCATE TABLE %s CASCADE', $tableName));
    }

    protected function flush(): void
    {
        static::$entityManager->flush();
        static::$entityManager->clear();
    }
}
