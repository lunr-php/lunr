<?php

/**
 * This file contains the SQLite3DMLQueryBuilderOrderByTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * order by statements.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderOrderByTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the order by part of a query.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::order_by
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::order_by
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelfReference()
    {
        $return = $this->class->order_by( 'col' );

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
