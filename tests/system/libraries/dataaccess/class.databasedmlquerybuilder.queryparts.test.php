<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
     * Test specifying the select part of a query, no escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectNoEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));

        $string = 'col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectNoEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, TRUE));

        $string = 'HEX(col) AS col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAlias
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', TRUE, FALSE));

        $string = '`col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAliasHex
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', TRUE, TRUE));

        $string = 'HEX(`col`) AS `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectNoEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));

        $string = 'col, col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectNoEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', FALSE, TRUE));

        $string = 'col, HEX(col) AS col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAlias
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', TRUE, FALSE));

        $string = 'col, `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAliasHex
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', TRUE, TRUE));

        $string = 'col, HEX(`col`) AS `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFrom()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));

        $string = 'FROM `table`';

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

}

?>
