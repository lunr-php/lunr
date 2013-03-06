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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_select
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
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_select
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
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
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
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
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
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
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
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
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
     * Test specifying more than one table in FROM (cartesian product).
     *
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testIncrementalFromWithoutIndices()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));
        $method->invokeArgs($this->builder, array('table'));

        $string = 'FROM table, table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying more than one table in FROM (cartesian product).
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testIncrementalFromWithIndices()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $method->invokeArgs($this->builder, array('table', $hints));
        $method->invokeArgs($this->builder, array('table', $hints));

        $string = 'FROM table index_hint, table index_hint';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithoutIndexHints($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table', $type));

        $string = trim($join . ' table');

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithSingleIndexHint($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $method->invokeArgs($this->builder, array('table', $type, $hints));

        $string = trim($join . ' table index_hint');

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithMultipleIndexHints($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $hints = array('index_hint', 'index_hint');

        $method->invokeArgs($this->builder, array('table', $type, $hints));

        $string = trim($join . ' table index_hint, index_hint');

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithNULLIndexHints($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $hints = array(NULL, NULL);

        $method->invokeArgs($this->builder, array('table', $type, $hints));

        $string = ltrim($join . ' table ');

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithoutIndexes($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table', $type));
        $method->invokeArgs($this->builder, array('table', $type));

        $string = $join . ' table ' . $join . ' table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithIndexes($type, $join)
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $method->invokeArgs($this->builder, array('table', $type, $hints));
        $method->invokeArgs($this->builder, array('table', $type, $hints));

        $string = $join . ' table index_hint ' . $join . ' table index_hint';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query with a STRAIGHT type.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testStraightJoin()
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table', 'STRAIGHT'));

        $string = 'STRAIGHT_JOIN table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query with a STRAIGHT type.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalStraightJoin()
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table', 'STRAIGHT'));
        $method->invokeArgs($this->builder, array('table', 'STRAIGHT'));

        $string = 'STRAIGHT_JOIN table STRAIGHT_JOIN table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test that specifying a join clause sets the property is_join.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinSetsIsJoin()
    {
        $method = $this->builder_reflection->getMethod('sql_join');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('is_join');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table', 'INNER'));

        $this->assertTrue($property->getValue($this->builder));
    }

    /**
     * Test specifying a logical connector for the query.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_connector
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
     * Test specifying the UNION part of a query.
     *
     * @dataProvider compoundQueryTypeProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_compound
     */
    public function testCompoundQuery($types)
    {
        $method = $this->builder_reflection->getMethod('sql_compound');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('compound');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('(sql query)', $types));

        $string = $types . ' (sql query)';
        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
    * Test creating a simple where/having statement.
    *
    * @param String $keyword   The expected statement keyword
    * @param String $attribute The name of the property where the statement is stored
    *
    * @dataProvider ConditionalKeywordProvider
    * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_condition
    */
    public function testConditionCreatesSimpleStatement($keyword, $attribute)
    {
        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty($attribute);
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('a', 'b', '=', $keyword));

        $string = "$keyword a = b";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
    * Test creating a simple JOIN ON statement.
    *
    * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_condition
    */
    public function testConditionCreatesSimpleJoinStatement()
    {
        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('is_join');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, TRUE);

        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, 'JOIN table');

        $method->invokeArgs($this->builder, array('a', 'b', '=', 'ON'));

        $string = 'JOIN table ON a = b';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a where/having statement with non-default operator.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionWithNonDefaultOperator($keyword, $attribute)
    {
        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty($attribute);
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('a', 'b', '<', $keyword));

        $string = "$keyword a < b";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test extending a where/having statement with default connector.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithDefaultConnector($keyword, $attribute)
    {
        $string = "$keyword a = b";

        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty($attribute);
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $string);

        $method->invokeArgs($this->builder, array('c', 'd', '=', $keyword));

        $string = "$keyword a = b AND c = d";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test extending a where/having statement with a specified connector.
     *
     * @param String $keyword   The expected statement keyword
     * @param String $attribute The name of the property where the statement is stored
     *
     * @dataProvider ConditionalKeywordProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_condition
     */
    public function testConditionExtendingWithSpecifiedConnector($keyword, $attribute)
    {
        $string = "$keyword a = b";

        $method = $this->builder_reflection->getMethod('sql_condition');
        $method->setAccessible(TRUE);

        $connector = $this->builder_reflection->getProperty('connector');
        $connector->setAccessible(TRUE);
        $connector->setValue($this->builder, 'OR');

        $property = $this->builder_reflection->getProperty($attribute);
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $string);

        $method->invokeArgs($this->builder, array('c', 'd', '=', $keyword));

        $string = "$keyword a = b OR c = d";

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a simple order by statement.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithDefaultOrder()
    {
        $string = 'ORDER BY col1 ASC';

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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithCustomOrder()
    {
        $string = 'ORDER BY col1 DESC';

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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_order_by
     */
    public function testOrderByWithExtendedStatement()
    {
        $value = 'ORDER BY col1 DESC';

        $method = $this->builder_reflection->getMethod('sql_order_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $value );

        $method->invokeArgs($this->builder, array('col2', FALSE));

        $string = 'ORDER BY col1 DESC, col2 DESC';


        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a simple group by statement.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupBy()
    {
        $string = 'GROUP BY group1';

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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_group_by
     */
    public function testGroupByExtending()
    {
        $value = 'GROUP BY group1';

        $method = $this->builder_reflection->getMethod('sql_group_by');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);
        $property->setValue($this->builder, $value);

        $method->invokeArgs($this->builder, array('group2'));

        $string = 'GROUP BY group1, group2';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test creating a limit statement with default offset.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithDefaultOffset()
    {
        $string = 'LIMIT 10';

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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_limit
     */
    public function testLimitWithCustomOffset()
    {
        $string = 'LIMIT 10 OFFSET 20';

        $method = $this->builder_reflection->getMethod('sql_limit');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('10', '20'));

        $this->assertEquals($string, $property->getValue($this->builder));
    }
}

?>
