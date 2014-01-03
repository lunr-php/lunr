<?php

/**
 * This file contains the DatabaseDMLQueryBuilderImplodeQueryTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderImplodeQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test imploding a query with no components specified.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithNoComponents()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $components = [];

        $this->assertEquals('', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with non existing components specified.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithNonExistingComponent()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $components = [ 'whatever' ];

        $this->assertEquals('', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with existing but empty components specified.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithExistingEmptyComponents()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $components = [ 'select_mode', 'select', 'from' ];

        $this->assertEquals('', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with existing but empty select components specified.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithEmptySelectComponent()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $this->set_reflection_property_value('from', 'FROM table');

        $components = [ 'select', 'from' ];

        $this->assertEquals('* FROM table', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with dupliacte select_mode values.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateSelectModes()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('select_mode', [ 'DISTINCT', 'DISTINCT', 'SQL_CACHE' ]);

        $components = [ 'select_mode', 'select', 'from' ];

        $this->assertEquals('DISTINCT SQL_CACHE * FROM table', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with dupliacte update_mode values.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateUpdateModes()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $this->set_reflection_property_value('update', 'table1');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE', 'LOW_PRIORITY' ]);

        $components = [ 'update_mode', 'update' ];

        $this->assertEquals('LOW_PRIORITY IGNORE table1', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with dupliacte delete_mode values.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateDeleteModes()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('delete_mode', [ 'QUICK', 'IGNORE', 'QUICK' ]);

        $components = [ 'delete_mode', 'from' ];

        $this->assertEquals('QUICK IGNORE FROM table', $method->invokeArgs($this->class, [ $components ]));
    }

    /**
     * Test imploding a query with dupliacte insert_mode values.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateInsertModes()
    {
        $method = $this->get_accessible_reflection_method('implode_query');

        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('insert_mode', [ 'DELAYED', 'IGNORE', 'DELAYED' ]);

        $components = [ 'insert_mode', 'into' ];

        $this->assertEquals('DELAYED IGNORE INTO table', $method->invokeArgs($this->class, [ $components ]));
    }

}
