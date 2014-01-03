<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetReplaceQueryTest class.
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
class DatabaseDMLQueryBuilderGetReplaceQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test get replace query with undefined INTO clause.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceQueryWithUndefinedInto()
    {
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = '';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using column names and values.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceValuesQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = 'REPLACE INTO table (column1, column2) VALUES (1,2), (3,4)';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SET.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSetQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('set', 'SET column1 = 1');

        $string = 'REPLACE INTO table SET column1 = 1';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SELECT.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SELECT with ColumnNames.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectColumnsQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table (column1, column2) SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SELECT with an invalid replace mode.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectInvalidInsertModeQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');
        $this->set_reflection_property_value('insert_mode', [ 'DELAYED', 'IGNORE' ]);

        $string = 'REPLACE DELAYED INTO table (column1, column2) SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

}

?>
