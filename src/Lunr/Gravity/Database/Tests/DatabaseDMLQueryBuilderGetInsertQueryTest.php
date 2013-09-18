<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetInsertQueryTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
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
class DatabaseDMLQueryBuilderGetInsertQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test get insert query with undefined INTO clause.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertQueryWithUndefinedInto()
    {
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = '';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using column names and values.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertValuesQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = 'INSERT INTO table (column1, column2) VALUES (1,2), (3,4)';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SET.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSetQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('set', 'SET column1 = 1');

        $string = 'INSERT INTO table SET column1 = 1';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SELECT.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SELECT with ColumnNames.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectColumnsQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table (column1, column2) SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SELECT with an invalid insert mode.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectInvalidInsertModeQuery()
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');
        $this->set_reflection_property_value('insert_mode', [ 'DELAYED', 'IGNORE' ]);

        $string = 'INSERT IGNORE INTO table (column1, column2) SELECT column1, column2 FROM table';

        $this->assertEquals($string, $this->class->get_insert_query());
    }

}

?>
