<?php

namespace Lucaszz\TestsWithDatabaseExamples\Tests;

use Doctrine\ORM\EntityManager;
use Lucaszz\TestsWithDatabaseExamples\Component\Factory\EntityManagerFactory;

class EntityManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_creates_instance_of_entity_manager()
    {
        $this->assertInstanceOf(
            EntityManager::class,
            EntityManagerFactory::create(
                [
                    'driver'   => 'pdo_mysql',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'database-test',
                ]
            )
        );
    }
}
