<?php
/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsWithTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Koen Hengsdijk
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
class DatabaseDMLQueryBuilderQueryPartsWithTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the with part of a query without recursion and without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testNonRecursiveWithWithoutColumnNames()
    {
        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias', 'query' ]);

        $string = 'alias AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying multiple with statements in a query without recursion and without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testMultipleNonRecursiveWithWithoutColumnNames()
    {
        $this->set_reflection_property_value('with', 'alias AS ( query )');

        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias2', 'query2' ]);

        $string = 'alias AS ( query ), alias2 AS ( query2 )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying the with part of a query without recursion but with column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testNonRecursiveWithIncludingColumnNames()
    {
        $method = $this->get_accessible_reflection_method('sql_with');

        $column_names = [ 'column1', 'column2', 'column3' ];

        $method->invokeArgs($this->class, [ 'alias', 'query', '', '', $column_names ]);

        $string = 'alias (column1, column2, column3) AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying multiple with statements in a query without recursion and with column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testMultipleNonRecursiveWithIncludingColumnNames()
    {
        $this->set_reflection_property_value
            ('with', 'alias (column1, column2, column3) AS ( query )');

        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias2', 'query2' ]);

        $string = 'alias (column1, column2, column3) AS ( query ), alias2 AS ( query2 )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying the with part of a query with recursion and without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithWithoutColumnNames()
    {
        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION']);

        $string = 'alias AS ( anchor_query UNION recursive_query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying the with part of a query with recursion and with column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithWithColumnNames()
    {
        $method = $this->get_accessible_reflection_method('sql_with');

        $column_names = array('column1', 'column2', 'column3');

        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION', $column_names ]);

        $string = 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a recursive query after a  non recursive query has been specified withouth column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithAfterNonRecursiveQueryWithoutColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias AS ( query )');

        $method = $this->get_accessible_reflection_method('sql_with');

        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION' ]);

        $string = 'alias AS ( anchor_query UNION recursive_query ), alias AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a recursive query after a non recursive query has been specified using column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithAfterNonRecursiveQueryWithColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias (column1, column2, column3) AS ( query )');

        $column_names = array('column1', 'column2', 'column3');

        $method = $this->get_accessible_reflection_method('sql_with');

        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION', $column_names ]);

        $string  = 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query ),';
        $string .= ' alias (column1, column2, column3) AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a recursive query after a recursive query has been specified without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithAfterRecursiveQueryWithoutColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias AS ( anchor_query UNION recursive_query )');

        $method = $this->get_accessible_reflection_method('sql_with');

        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION' ]);

        $string = 'alias AS ( anchor_query UNION recursive_query ), alias AS ( anchor_query UNION recursive_query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a recursive query after a recursive query has been specified using column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testRecursiveWithAfterRecursiveQueryWithColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query )');

        $column_names = array('column1', 'column2', 'column3');

        $method = $this->get_accessible_reflection_method('sql_with');

        $method->invokeArgs($this->class, [ 'alias', 'anchor_query', 'recursive_query', 'UNION', $column_names ]);

        $string  = 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query ), ';
        $string .= 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a non recursive query after a recursive query has been specified without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testNonRecursiveWithAfterRecursiveQueryWithoutColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias AS ( anchor_query UNION recursive_query )');

        $method = $this->get_accessible_reflection_method('sql_with');

        $method->invokeArgs($this->class, [ 'alias', 'query' ]);

        $string = 'alias AS ( anchor_query UNION recursive_query ), alias AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying a non recursive query after a recursive query has been specified using column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testNonRecursiveWithAfterRecursiveQueryWithColumnNames()
    {
        $this->set_reflection_property_value
        ('with', 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query )');

        $method = $this->get_accessible_reflection_method('sql_with');

        $column_names = array('column1', 'column2', 'column3');

        $method->invokeArgs($this->class, [ 'alias', 'query', '', '', $column_names ]);

        $string  = 'alias (column1, column2, column3) AS ( anchor_query UNION recursive_query ), ';
        $string .= 'alias (column1, column2, column3) AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

}
