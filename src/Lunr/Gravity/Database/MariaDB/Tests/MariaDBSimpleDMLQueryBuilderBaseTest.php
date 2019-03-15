<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderBaseTest class.
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
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use Lunr\Gravity\Database\MariaDB\Tests\MariaDBSimpleDMLQueryBuilderTest;

/**
 * This class contains basic tests for the MariaDBSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder
 */
class MariaDBSimpleDMLQueryBuilderBaseTest extends MariaDBSimpleDMLQueryBuilderTest
{

    /**
     * Test the builder class is passed correctly.
     */
    public function testBuilderIsPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder';
        $this->assertInstanceOf($instance, $this->builder);
    }

    /**
     * Test the QueryEscaper class is passed correctly.
     */
    public function testEscaperIsPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MySQL\MySQLQueryEscaper';
        $this->assertInstanceOf($instance, $this->escaper);
    }

}

?>
