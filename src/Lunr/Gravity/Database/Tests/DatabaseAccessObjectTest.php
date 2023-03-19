<?php

/**
 * This file contains the DatabaseAccessObjectTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * @covers Lunr\Gravity\Database\DatabaseAccessObject
 */
abstract class DatabaseAccessObjectTest extends LunrBaseTest
{

    /**
     * Mock instance of the DatabaseConnectionPool
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Mock instance of a DatabaseConnection
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * Mock instance of the Logger class.
     * @var Logger
     */
    protected $logger;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpNoPool(): void
    {
        $this->pool = NULL;

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($escaper));

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseAccessObject')
                            ->setConstructorArgs([ $this->db, $this->logger ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseAccessObject');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpPool(): void
    {
        $this->pool = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnectionPool')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                        ->disableOriginalConstructor()
                        ->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($escaper));

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseAccessObject')
                            ->setConstructorArgs([ $this->db, $this->logger, $this->pool ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseAccessObject');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->pool);
        unset($this->db);
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
