<?php

/**
 * This file contains the SQLDMLQueryBuilderOrderByTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * order by statements.
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderOrderByTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the order by part of a query.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithDefaultOrder()
    {
        $this->class->order_by('col');
        $value = $this->get_reflection_property_value('order_by');

        $this->assertEquals('ORDER BY col ASC', $value);
    }

    /**
     * Test specifying the order by part of a query.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithCustomOrder()
    {
        $this->class->order_by('col', FALSE);
        $value = $this->get_reflection_property_value('order_by');

        $this->assertEquals('ORDER BY col DESC', $value);
    }

    /**
     * Test fluid interface of the order_by method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelfReference()
    {
        $return = $this->class->order_by( 'col' );

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
