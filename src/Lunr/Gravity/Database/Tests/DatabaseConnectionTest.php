<?php

/**
 * This file contains the DatabaseConnectionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnection;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseConnection class.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnection
 */
abstract class DatabaseConnectionTest extends LunrBaseTest
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnection')
                            ->setConstructorArgs([ &$this->configuration, &$this->logger ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
