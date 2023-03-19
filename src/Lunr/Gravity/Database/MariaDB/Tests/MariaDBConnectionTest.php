<?php

/**
 * This file contains the MariaDBConnectionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\MariaDBConnection;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common constructors/destructors for testing the MariaDBConnection class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBConnection
 */
class MariaDBConnectionTest extends LunrBaseTest
{

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
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the mysqli class.
     * @var mysqli
     */
    protected $mysqli;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
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
            [ 'driver', 'mariadb' ],
        ];

        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->mysqli = $this->getMockBuilder('\mysqli')->getMock();

        $this->class = new MariaDBConnection($this->configuration, $this->logger, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->configuration);
        unset($this->logger);

        parent::tearDown();
    }

}

?>
