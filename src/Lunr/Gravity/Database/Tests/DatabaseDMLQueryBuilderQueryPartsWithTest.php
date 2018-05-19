<?php
/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsWithTest class.
 *
 * PHP Version 5.4
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

        $string = 'WITH alias AS ( query )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

    /**
     * Test specifying multiple with statements in a query without recursion and without column names
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_with
     */
    public function testMultipleNonRecursiveWithWithoutColumnNames()
    {
        $this->set_reflection_property_value('with', 'WITH alias AS ( query )');

        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias2', 'query2']);

        $string = 'WITH alias AS ( query ), alias2 AS ( query2 )';

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

        $column_names = ['column1', 'column2', 'column3'];

        $method->invokeArgs($this->class, [ 'alias', 'query', $column_names ]);

        $string = 'WITH alias (column1, column2, column3) AS ( query )';

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
            ('with', 'WITH alias (column1, column2, column3) AS ( query )');

        $method = $this->get_accessible_reflection_method('sql_with');
        $method->invokeArgs($this->class, [ 'alias2', 'query2']);

        $string = 'WITH alias (column1, column2, column3) AS ( query ), alias2 AS ( query2 )';

        $this->assertEquals($string, $this->get_reflection_property_value('with'));
    }

}
