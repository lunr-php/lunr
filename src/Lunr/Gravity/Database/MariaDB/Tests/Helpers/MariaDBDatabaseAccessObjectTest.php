<?php

/**
 * This file contains the MariaDBDatabaseAccessObjectTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2019 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MariaDB\Tests\Helpers;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains setup and tear down methods for DAOs using MariaDB access.
 */
abstract class MariaDBDatabaseAccessObjectTest extends LunrBaseTest
{

    /**
     * Mock instance of the MariaDBConnection class.
     * @var \Lunr\Gravity\Database\MariaDB\MariaDBConnection
     */
    protected $db;

    /**
     * Mock instance of the Logger class
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the DMLQueryBuilder class
     * @var \Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
     */
    protected $builder;

    /**
     * Mock instance of the QueryEscaper class
     * @var \Lunr\Gravity\Database\MySQL\MySQLQueryEscaper
     */
    protected $escaper;

    /**
     * Mock instance of the QueryResult class
     * @var \Lunr\Gravity\Database\MySQL\MySQLQueryResult
     */
    protected $result;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MariaDB\MariaDBConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->builder = $this->getMockBuilder('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->escaper = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryEscaper')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->result = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->db->expects($this->once())
                 ->method('get_query_escaper_object')
                 ->will($this->returnValue($this->escaper));

        // Assumption: All DAO's end in DAO.
        $name = str_replace('\\Tests\\', '\\', substr(static::class, 0, strrpos(static::class, 'DAO') + 3));

        $this->class = new $name($this->db, $this->logger);

        $this->reflection = new ReflectionClass($name);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->db);
        unset($this->logger);
        unset($this->builder);
        unset($this->escaper);
        unset($this->result);
    }

}

?>
