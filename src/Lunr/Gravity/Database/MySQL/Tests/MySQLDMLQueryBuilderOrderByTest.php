<?php

/**
 * This file contains the MySQLDMLQueryBuilderOrderByTest class.
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
 * order by statements.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderOrderByTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the order by part of a query.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithDefaultOrder()
    {
        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);

        $this->builder->order_by('col');

        $this->assertEquals('ORDER BY col ASC', $property->getValue($this->builder));
    }

    /**
     * Test specifying the order by part of a query.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithCustomOrder()
    {
        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);

        $this->builder->order_by('col', FALSE);

        $this->assertEquals('ORDER BY col DESC', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the order_by method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelfReference()
    {
        $return = $this->builder->order_by( 'col' );

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}
