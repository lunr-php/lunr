<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsInsertTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts methods that are used when building INSERT and REPLACE statements
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsInsertTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the SET part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSetEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_set
     */
    public function testInitialSet()
    {
        $method = $this->builder_reflection->getMethod('sql_set');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('set');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array( array('column1'=>'value1')));

        $string = 'SET column1 = value1';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the SET part of a query incrementally.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSetEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_set
     */
    public function testIncrementalSet()
    {
        $method = $this->builder_reflection->getMethod('sql_set');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('set');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array( array('column1'=>'value1')));
        $method->invokeArgs($this->builder, array( array('column2'=>'value2')));

        $string = 'SET column1 = value1, column2 = value2';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the Values part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testValuesEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_values
     */
    public function testInitialValues()
    {
        $method = $this->builder_reflection->getMethod('sql_values');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('values');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array( array(
                'value1',
                'value2',
                'value3'
            )));

        $string = 'VALUES (value1, value2, value3)';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the Values part of a query incrementally.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testValuesEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_values
     */
    public function testIncrementalValues()
    {
        $method = $this->builder_reflection->getMethod('sql_values');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('values');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array( array(
                'value1',
                'value2',
                'value3'
            )));
        $method->invokeArgs($this->builder, array( array(
                array(
                    'value4',
                    'value5',
                    'value6'
                ),
                array(
                    'value7',
                    'value8',
                    'value9'
                )
            )));

        $string = 'VALUES (value1, value2, value3), (value4, value5, value6), (value7, value8, value9)';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the column_names part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testColumnNamesEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_column_names
     */
    public function testInitialColumnNames()
    {
        $method = $this->builder_reflection->getMethod('sql_column_names');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('column_names');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array( array(
                'column1',
                'column2',
                'column3'
            )));

        $string = '(column1, column2, column3)';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectStatementEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInitialSelectStatement()
    {
        $method = $this->builder_reflection->getMethod('sql_select_statement');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select_statement');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('SELECT * FROM table1'));

        $string = 'SELECT * FROM table1';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectStatementEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInvalidSelectStatement()
    {
        $method = $this->builder_reflection->getMethod('sql_select_statement');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select_statement');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('INSERT INTO table1'));

        $string = '';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testIntoEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_into
     */
    public function testInitialInto()
    {
        $method = $this->builder_reflection->getMethod('sql_into');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('into');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table1'));

        $string = 'INTO table1';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testIntoEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_into
     */
    public function testIncrementalInto()
    {
        $method = $this->builder_reflection->getMethod('sql_into');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('into');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table1'));
        $method->invokeArgs($this->builder, array('table2'));

        $string = 'INTO table2';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

}
?>
