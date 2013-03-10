<?php

/**
 * This file contains the MySQLDMLQueryBuilderLimitTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * limit statements.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderLimitTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the limit part of a query with default offset.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::limit
     */
    public function testLimitWithDefaultOffset()
    {
        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $this->builder->limit(10);

        $this->assertEquals('LIMIT 10', $property->getValue($this->builder));
    }

    /**
     * Test specifying the limit part of a query with custom offset.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::limit
     */
    public function testLimitWithCustomOffset()
    {
        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $this->builder->limit(10, 20);

        $this->assertEquals('LIMIT 10 OFFSET 20', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the limit method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelfReference()
    {
        $return = $this->builder->limit(10);

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
