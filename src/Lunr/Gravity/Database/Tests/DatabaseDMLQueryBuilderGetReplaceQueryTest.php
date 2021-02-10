<?php

/**
 * This file contains the DatabaseDMLQueryBuilderGetReplaceQueryTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderGetReplaceQueryTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test get replace query with undefined INTO clause.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceQueryWithUndefinedInto(): void
    {
        $this->expectException('\Lunr\Gravity\Database\Exceptions\MissingTableReferenceException');
        $this->expectExceptionMessage('No into() in replace query!');

        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $this->class->get_replace_query();
    }

    /**
     * Test get replace query using column names and values.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceValuesQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = 'REPLACE INTO table (column1, column2) VALUES (1,2), (3,4)';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace...returning query using column names and values.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceReturningValuesQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');
        $this->set_reflection_property_value('returning', 'RETURNING column1, column2');

        $string = 'REPLACE INTO table (column1, column2) VALUES (1,2), (3,4) RETURNING column1, column2';

        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SET.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderImplodeQueryTest::testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSetQuery(): void
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
    public function testGetReplaceSelectQuery(): void
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
    public function testGetReplaceSelectColumnsQuery(): void
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
    public function testGetReplaceSelectInvalidInsertModeQuery(): void
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
