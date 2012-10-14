<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts methods.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelect()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col'));

        $string = 'col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelect()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col'));
        $method->invokeArgs($this->builder, array('col'));

        $string = 'col, col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query without index hints.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithoutIndexHints()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));

        $string = 'FROM table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query with single index hint.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithSingleIndexHint()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $method->invokeArgs($this->builder, array('table', $hints));

        $string = 'FROM table index_hint';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query with multiple index hints.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithMultipleIndexHints()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $hints = array('index_hint', 'index_hint');

        $method->invokeArgs($this->builder, array('table', $hints));

        $string = 'FROM table index_hint, index_hint';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query with null index hints.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithNullIndexHints()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $hints = array(NULL, NULL);

        $method->invokeArgs($this->builder, array('table', $hints));

        $string = 'FROM table ';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying a logical connector for the query.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_connector
     */
    public function testConnector()
    {
        $method = $this->builder_reflection->getMethod('sql_connector');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('connector');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('AND'));

        $this->assertEquals('AND', $property->getValue($this->builder));
    }

    /**
     * Test creating a simple where/having statement.
     *
     * @param Boolean $where   Whether to test where or having
     * @param String  $keyword The expected statement keyword
     *
     * @dataProvider whereOrHavingProvider
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionCreatesSimpleStatement($where, $keyword)
    {
        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty(strtolower($keyword));
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('a', 'b', '=', $where));

        $string = "$keyword a = b";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a where/having statement with non-default operator.
     *
     * @param Boolean $where   Whether to test where or having
     * @param String  $keyword The expected statement keyword
     *
     * @dataProvider whereOrHavingProvider
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionWithNonDefaultOperator($where, $keyword)
    {
        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty(strtolower($keyword));
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('a', 'b', '<', $where));

        $string = "$keyword a < b";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test extending a where/having statement with default connector.
     *
     * @param Boolean $where   Whether to test where or having
     * @param String  $keyword The expected statement keyword
     *
     * @dataProvider whereOrHavingProvider
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithDefaultConnector($where, $keyword)
    {
        $string = "$keyword a = b";

        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty(strtolower($keyword));
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $string);

        $method->invokeArgs($this->builder, array('c', 'd', '=', $where));

        $string = "$keyword a = b AND c = d";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test extending a where/having statement with a specified connector.
     *
     * @param Boolean $where   Whether to test where or having
     * @param String  $keyword The expected statement keyword
     *
     * @dataProvider whereOrHavingProvider
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithSpecifiedConnector($where, $keyword)
    {
        $string = "$keyword a = b";

        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $connector = $this->builder_reflection->getProperty('connector');
        $connector->setAccessible(TRUE);
        $connector->setValue($this->builder, 'OR');

        $property = $this->builder_reflection->getProperty(strtolower($keyword));
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $string);

        $method->invokeArgs($this->builder, array('c', 'd', '=', $where));

        $string = "$keyword a = b OR c = d";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a simple order by statement.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithDefaultOrder()
    {
        $string = "ORDER BY col1 ASC";

        $method = $this->builder_reflection->getMethod('sql_order_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col1'));

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a order by statement with custom order.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithCustomOrder()
    {
        $string = "ORDER BY col1 DESC";

        $method = $this->builder_reflection->getMethod('sql_order_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col1', FALSE));

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating and extending a order by statement.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithExtendedStatement()
    {
        $value = "ORDER BY col1 DESC";

        $method = $this->builder_reflection->getMethod('sql_order_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $value );

        $method->invokeArgs($this->builder, array('col2', FALSE));

        $string = "ORDER BY col1 DESC, col2 DESC";


        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a simple group by statement.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupBy()
    {
        $string = "GROUP BY group1";

        $method = $this->builder_reflection->getMethod('sql_group_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('group1'));

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating and extending a group by statement.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupByExtending()
    {
        $value = "GROUP BY group1";

        $method = $this->builder_reflection->getMethod('sql_group_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $value);

        $method->invokeArgs($this->builder, array('group2'));

        $string = "GROUP BY group1, group2";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a limit statement with default offset.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithDefaultOffset()
    {
        $string = "LIMIT 10";

        $method = $this->builder_reflection->getMethod('sql_limit');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('10'));

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a limit statement with custom offset.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithCustomOffset()
    {
        $string = "LIMIT 10 OFFSET 20";

        $method = $this->builder_reflection->getMethod('sql_limit');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('10', '20'));

        $this->assertEquals($string, $property->getValue($this->builder));
    }

}

?>
