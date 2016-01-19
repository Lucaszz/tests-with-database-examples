<?php

namespace Lucaszz\TestsWithDatabaseExamples\Tests\Logger;

use Lucaszz\TestsWithDatabaseExamples\Logger\Logger;
use Psr\Log\LoggerInterface;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_logs()
    {
        $monologLogger = $this->prophesize(LoggerInterface::class);

        $logger = new Logger($monologLogger->reveal());
        $logger->startQuery('SELECT * FROM TABLE xyx', []);

        $monologLogger->debug('SELECT * FROM TABLE xyx', [])->shouldBeCalled();
    }
}