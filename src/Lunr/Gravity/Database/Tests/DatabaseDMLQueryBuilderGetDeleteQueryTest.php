<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetDeleteQueryTest class.
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
class DatabaseDMLQueryBuilderGetDeleteQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test getting a delete query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQuery()
    {
        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('delete_mode', [ 'QUICK', 'IGNORE' ]);
        $this->set_reflection_property_value('delete', 'table.*');
        $this->set_reflection_property_value('join', 'INNER JOIN table1');
        $this->set_reflection_property_value('where', 'WHERE a = b');

        $string = 'DELETE QUICK IGNORE table.* FROM table INNER JOIN table1 WHERE a = b';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

    /**
     * Test getting a delete query with undefined FROM.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQueryWithUndefinedFrom()
    {
        $this->set_reflection_property_value('delete_mode', [ 'QUICK', 'IGNORE' ]);
        $this->set_reflection_property_value('delete', 'table.*');

        $string = '';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

    /**
     * Test getting a delete query with empty selection.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetEmptyDeleteQuery()
    {
        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('delete_mode', [ 'QUICK', 'IGNORE' ]);

        $string = 'DELETE QUICK IGNORE FROM table';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

    /**
     * Test getting a delete query with limit and orderBy.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetEmptyDeleteLimitOrderQuery()
    {
        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('limit', 'LIMIT 10 OFFSET 0');
        $this->set_reflection_property_value('order_by', 'ORDER BY col ASC');

        $string = 'DELETE FROM table ORDER BY col ASC LIMIT 10 OFFSET 0';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

    /**
     * Test it is not possible to get a delete query with limit and orderBy when delete is not ''.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteLimitOrderQuery()
    {
        $this->set_reflection_property_value('delete', 'table.*');
        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('limit', 'LIMIT 10 OFFSET 0');
        $this->set_reflection_property_value('order_by', 'ORDER BY col ASC');

        $string = 'DELETE table.* FROM table';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

    /**
     * Test it is not possible to get a delete query with limit and orderBy when join is not ''.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteLimitOrderQueryWithJoin()
    {
        $this->set_reflection_property_value('join', 'INNER JOIN table1');
        $this->set_reflection_property_value('from', 'FROM table');
        $this->set_reflection_property_value('limit', 'LIMIT 10 OFFSET 0');
        $this->set_reflection_property_value('order_by', 'ORDER BY col ASC');

        $string = 'DELETE FROM table INNER JOIN table1';

        $this->assertEquals($string, $this->class->get_delete_query());
    }

}

?>
