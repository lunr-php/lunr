<?php

/**
 * This file contains the SQLDMLQueryBuilderInsertTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * insert/replace queries.
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderInsertTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test fluid interface of the select_statement method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::select_statement
     */
    public function testSelectStatementReturnsSelfReference()
    {
        $return = $this->class->select_statement('SELECT * FROM table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the into method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::into
     */
    public function testIntoReturnsSelfReference()
    {
        $return = $this->class->into('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the column_names method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::column_names
     */
    public function testColumnNamesReturnsSelfReference()
    {
        $return = $this->class->column_names(array('column1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the values method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::values
     */
    public function testValuesReturnsSelfReference()
    {
        $return = $this->class->values(array('value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
