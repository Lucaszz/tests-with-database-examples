<?php

namespace Lucaszz\TestsWithDatabaseExamples\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Lucaszz\TestsWithDatabaseExamples\Component\Config\MysqlConfig;
use Lucaszz\TestsWithDatabaseExamples\Component\Config\SqliteConfig;
use Lucaszz\TestsWithDatabaseExamples\Component\Factory\EntityManagerFactory;
use Lucaszz\TestsWithDatabaseExamples\Component\Fixtures\LoadItems;
use Lucaszz\TestsWithDatabaseExamples\Model\Item;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var EntityManager */
    private $entityManager;
    /** @var EntityRepository */
    private $items;

    /**
     * @return array
     */
    public function items()
    {
        return array_fill(1, LoadItems::COUNT, []);
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->givenMysqlDatabaseWasConnected();
        $this->items = $this->entityManager->getRepository(Item::class);
    }

    protected function givenMysqlDatabaseWasConnected()
    {
        $this->entityManager = EntityManagerFactory::create(MysqlConfig::getParams());
    }

    protected function givenSqliteDatabaseWasConnected()
    {
        $this->entityManager = EntityManagerFactory::create(SqliteConfig::getParams());
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->entityManager = null;
        $this->items         = null;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function add($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    protected function findItemByName($name)
    {
        $item = $this->items->findOneBy(['name' => $name]);

        if (null === $item) {
            throw new \InvalidArgumentException(sprintf('Item with name %s does not exist.', $name));
        }

        return $item;
    }

    protected function givenDatabaseIsClear()
    {
        if (0 !== count($this->items->findAll())) {
            $purger = new ORMPurger($this->entityManager);
            $purger->purge();
        }
    }
}
