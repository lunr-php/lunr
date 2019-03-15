<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsJoinTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsJoinTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithoutIndexHints($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', $type ]);

        $string = trim($join . ' table');

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithSingleIndexHint($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $hints = [ 'index_hint' ];

        $method->invokeArgs($this->class, [ 'table', $type, $hints ]);

        $string = trim($join . ' table index_hint');

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithMultipleIndexHints($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');
        $hints  = [ 'index_hint', 'index_hint' ];

        $method->invokeArgs($this->class, [ 'table', $type, $hints ]);

        $string = trim($join . ' table index_hint, index_hint');

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithNULLIndexHints($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');
        $hints  = [ NULL, NULL ];

        $method->invokeArgs($this->class, [ 'table', $type, $hints ]);

        $string = ltrim($join . ' table ');

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithoutIndexes($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', $type ]);
        $method->invokeArgs($this->class, [ 'table', $type ]);

        $string = $join . ' table ' . $join . ' table';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param string $type Type of join to perform
     * @param string $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithIndexes($type, $join): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');
        $hints  = [ 'index_hint' ];

        $method->invokeArgs($this->class, [ 'table', $type, $hints ]);
        $method->invokeArgs($this->class, [ 'table', $type, $hints ]);

        $string = $join . ' table index_hint ' . $join . ' table index_hint';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query with a STRAIGHT type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testStraightJoin(): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'STRAIGHT' ]);

        $string = 'STRAIGHT_JOIN table';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query with a STRAIGHT type.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalStraightJoin(): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'STRAIGHT' ]);
        $method->invokeArgs($this->class, [ 'table', 'STRAIGHT' ]);

        $string = 'STRAIGHT_JOIN table STRAIGHT_JOIN table';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test that specifying a join clause sets the property is_unfinished_join to FALSE
     * when there is a natural join.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinSetsUnfinishedJoinWithNaturalJoin(): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'NATURAL LEFT JOIN' ]);

        $this->assertFalse($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test that specifying a join clause sets the property is_unfinished_join to TRUE
     * when the join still has to be finished.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinSetsUnfinishedJoin(): void
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'INNER' ]);

        $this->assertTrue($this->get_reflection_property_value('is_unfinished_join'));
    }

    /**
     * Test that specifying a join clause resets the property join_type to ' ' after having used join before.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinSetsJoinType(): void
    {
        $this->set_reflection_property_value('join_type', 'on');

        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'INNER' ]);

        $this->assertTrue($this->get_reflection_property_value('is_unfinished_join'));
        $this->assertSame('', $this->get_reflection_property_value('join_type'));
    }

}

?>
