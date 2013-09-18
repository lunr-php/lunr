<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsFromTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
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
class DatabaseDMLQueryBuilderQueryPartsFromTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the from part of a query without index hints.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithoutIndexHints()
    {
        $method = $this->get_accessible_reflection_method('sql_from');

        $method->invokeArgs($this->class, [ 'table' ]);

        $string = 'FROM table';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

    /**
     * Test specifying the from part of a query with single index hint.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithSingleIndexHint()
    {
        $method = $this->get_accessible_reflection_method('sql_from');
        $hints  = [ 'index_hint' ];

        $method->invokeArgs($this->class, [ 'table', $hints ]);

        $string = 'FROM table index_hint';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

    /**
     * Test specifying the from part of a query with multiple index hints.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithMultipleIndexHints()
    {
        $method = $this->get_accessible_reflection_method('sql_from');
        $hints  = array('index_hint', 'index_hint');

        $method->invokeArgs($this->class, [ 'table', $hints ]);

        $string = 'FROM table index_hint, index_hint';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

    /**
     * Test specifying the from part of a query with null index hints.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFromWithNullIndexHints()
    {
        $method = $this->get_accessible_reflection_method('sql_from');
        $hints  = array(NULL, NULL);

        $method->invokeArgs($this->class, [ 'table', $hints ]);

        $string = 'FROM table ';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

    /**
     * Test specifying more than one table in FROM (cartesian product).
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testIncrementalFromWithoutIndices()
    {
        $method = $this->get_accessible_reflection_method('sql_from');

        $method->invokeArgs($this->class, [ 'table' ]);
        $method->invokeArgs($this->class, [ 'table' ]);

        $string = 'FROM table, table';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

    /**
     * Test specifying more than one table in FROM (cartesian product).
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareValidIndexHints
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testPrepareInvalidIndexHintsReturnsEmptyString
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_from
     */
    public function testIncrementalFromWithIndices()
    {
        $method = $this->get_accessible_reflection_method('sql_from');
        $hints  = array('index_hint');

        $method->invokeArgs($this->class, [ 'table', $hints ]);
        $method->invokeArgs($this->class, [ 'table', $hints ]);

        $string = 'FROM table index_hint, table index_hint';

        $this->assertEquals($string, $this->get_reflection_property_value('from'));
    }

}

?>
