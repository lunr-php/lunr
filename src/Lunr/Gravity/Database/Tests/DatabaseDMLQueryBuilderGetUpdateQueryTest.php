<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetUpdateQueryTest class.
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
class DatabaseDMLQueryBuilderGetUpdateQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test getting an update query without specifying a table.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryWithNoTable()
    {
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = '';

        $this->assertEquals($string, $this->class->get_update_query());
    }

    /**
     * Test getting an update query for single table.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForSingleTable()
    {
        $this->set_reflection_property_value('update', 'table1');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1 SET col1 = val1, col2 = val2 WHERE 1 = 1 ORDER BY col1 LIMIT 10';

        $this->assertEquals($string, $this->class->get_update_query());
    }

    /**
     * Test getting an update query for multiple tables.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForMultipleTables()
    {
        $this->set_reflection_property_value('update', 'table1, table2');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1, table2 SET col1 = val1, col2 = val2 WHERE 1 = 1';

        $this->assertEquals($string, $this->class->get_update_query());
    }

    /**
     * Test getting an update query for multiple tables using JOIN.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForMultipleTablesWithJoin()
    {
        $this->set_reflection_property_value('update', 'table1');
        $this->set_reflection_property_value('join', 'INNER JOIN table2');
        $this->set_reflection_property_value('update_mode', [ 'LOW_PRIORITY', 'IGNORE' ]);
        $this->set_reflection_property_value('set', 'SET col1 = val1, col2 = val2');
        $this->set_reflection_property_value('where', 'WHERE 1 = 1');
        $this->set_reflection_property_value('order_by', 'ORDER BY col1');
        $this->set_reflection_property_value('limit', 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1 INNER JOIN table2 SET col1 = val1, col2 = val2 WHERE 1 = 1';

        $this->assertEquals($string, $this->class->get_update_query());
    }

}

?>
