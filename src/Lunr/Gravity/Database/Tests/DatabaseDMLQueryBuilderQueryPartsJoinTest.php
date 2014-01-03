<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsJoinTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsJoinTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithoutIndexHints($type, $join)
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', $type ]);

        $string = trim($join . ' table');

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithSingleIndexHint($type, $join)
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
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithMultipleIndexHints($type, $join)
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
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinWithNULLIndexHints($type, $join)
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
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithoutIndexes($type, $join)
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
     * @param String $type Type of join to perform
     * @param String $join The join operation to perform
     *
     * @dataProvider commonJoinTypeProvider
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends      Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testIncrementalJoinWithIndexes($type, $join)
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
    public function testStraightJoin()
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
    public function testIncrementalStraightJoin()
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'STRAIGHT' ]);
        $method->invokeArgs($this->class, [ 'table', 'STRAIGHT' ]);

        $string = 'STRAIGHT_JOIN table STRAIGHT_JOIN table';

        $this->assertEquals($string, $this->get_reflection_property_value('join'));
    }

    /**
     * Test that specifying a join clause sets the property is_join.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_join
     */
    public function testJoinSetsIsJoin()
    {
        $method = $this->get_accessible_reflection_method('sql_join');

        $method->invokeArgs($this->class, [ 'table', 'INNER' ]);

        $this->assertTrue($this->get_reflection_property_value('is_join'));
    }

}

?>
