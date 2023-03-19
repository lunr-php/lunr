<?php

/**
 * This file contains the DatabaseConnectionPoolTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the DatabaseConnectionPool class.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnectionPool
 */
abstract class DatabaseConnectionPoolTest extends TestCase
{

    /**
     * Instance of the DatabaseConnectionPool class.
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Reflection instance of the DatabaseConnectionPool class.
     * @var ReflectionClass
     */
    protected $pool_reflection;

    /**
     * Mock instance of the sub Configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

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
     *
     * @return void
     */
    public function emptySetup(): void
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function unsupportedSetup(): void
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'unsupported' ],
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function supportedSetup(): void
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'db', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ],
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->pool = new DatabaseConnectionPool($this->configuration, $this->logger);

        $this->pool_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnectionPool');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->pool);
        unset($this->pool_reflection);
        unset($this->configuration);
        unset($this->logger);
    }

}

?>
