<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderWriteTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains update/delete/insert tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderWriteTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test into().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::into
     */
    public function testInto()
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('into')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->into('table');
    }

    /**
     * Test column_names() with a single column.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesWithOneColumn()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo(['`col`']))
                      ->will($this->returnSelf());

        $this->class->column_names([ 'col' ]);
    }

    /**
     * Test column_names() with multiple columns.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesWithMultipleColumns()
    {
        $this->escaper->expects($this->at(0))
                      ->method('column')
                      ->with($this->equalTo('col1'))
                      ->will($this->returnValue('`col1`'));

        $this->escaper->expects($this->at(1))
                      ->method('column')
                      ->with($this->equalTo('col2'))
                      ->will($this->returnValue('`col2`'));

        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo(['`col1`', '`col2`']))
                      ->will($this->returnSelf());

        $this->class->column_names([ 'col1', 'col2' ]);
    }

    /**
     * Test update() with one table to update.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::update
     */
    public function testUpdateWithOneTable()
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('update')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->update('table');
    }

    /**
     * Test update() with multiple tables to update.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::update
     */
    public function testUpdateWithMultipleTables()
    {
        $this->escaper->expects($this->at(0))
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->escaper->expects($this->at(1))
                      ->method('table')
                      ->with($this->equalTo(' table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('update')
                      ->with($this->equalTo('`table`, `table`'))
                      ->will($this->returnSelf());

        $this->class->update('table, table');
    }

}

?>
