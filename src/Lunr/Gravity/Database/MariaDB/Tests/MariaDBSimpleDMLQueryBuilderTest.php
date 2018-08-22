<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MMariaDBSimpleDMLQueryBuilder
 */
abstract class MariaDBSimpleDMLQueryBuilderTest extends TestCase
{

    /**
     * Mock instance of the MySQLConnection class
     * @var MySQLConnection
     */
    protected $db;

    /**
     * MySQL query escaper instance
     * @var MySQLQueryEscaper
     */
    protected $escaper;

    /**
     * Instance of the simple  query builder
     * @var MariaDBDMLQueryBuilder
     */
    protected $builder;

    /**
     * Reflection of the MariaDBSimpleQueryBuilder
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MariaDB\MariaDBConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->builder_reflection = $this->getMockBuilder('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder')
                                         ->getMock();

        $this->escaper    = new MySQLQueryEscaper($this->db);
        $this->builder    = new MariaDBSimpleDMLQueryBuilder($this->builder_reflection, $this->escaper);
        $this->reflection = new ReflectionClass($this->builder);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->db);
        unset($this->escaper);
        unset($this->builder);
        unset($this->reflection);
    }

}

?>
