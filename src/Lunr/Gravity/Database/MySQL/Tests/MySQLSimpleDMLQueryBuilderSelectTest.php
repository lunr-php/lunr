<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderSelectTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;
use ReflectionClass;

/**
 * This class contains select tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderSelectTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test get_insert_query() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::get_select_query
     */
    public function testGetSelectQuery()
    {
        $this->builder->expects($this->once())
                      ->method('get_select_query')
                      ->willReturn('');

        $this->class->get_select_query();
    }

    /**
     * Test select_mode() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select_mode
     */
    public function testSelectMode()
    {
        $this->builder->expects($this->once())
                      ->method('select_mode')
                      ->with('ALL')
                      ->will($this->returnSelf());

        $this->class->select_mode('ALL');
    }

    /**
     * Test select() with one input column.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select
     */
    public function testSelectWithOneColumn()
    {
        $this->escaper->expects($this->once())
                      ->method('result_column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('select')
                      ->with($this->equalTo('`col`'))
                      ->will($this->returnSelf());

        $this->class->select('col');
    }

    /**
     * Test select() with multiple input columns.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select
     */
    public function testSelectWithMultipleColumns()
    {
        $this->escaper->expects($this->at(0))
                      ->method('result_column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->escaper->expects($this->at(1))
                      ->method('result_column')
                      ->with($this->equalTo(' col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('select')
                      ->with($this->equalTo('`col`, `col`'))
                      ->willReturn($this->returnSelf());

        $this->class->select('col, col');
    }

    /**
     * Test from().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::from
     */
    public function testFrom()
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('from')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->from('table');
    }

    /**
     * Test join().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::join
     */
    public function testJoin()
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('table'))
                      ->will($this->returnValue('`table`'));

        $this->builder->expects($this->once())
                      ->method('join')
                      ->with($this->equalTo('`table`'))
                      ->will($this->returnSelf());

        $this->class->join('table');
    }

    /**
     * Test group_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::group_by
     */
    public function testGroupBy()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('group_by')
                      ->with($this->equalTo('`col`'))
                      ->will($this->returnSelf());

        $this->class->group_by('col');
    }

    /**
     * Test order_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::order_by
     */
    public function testOrderBy()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('order_by')
                      ->with($this->equalTo('`col`'), $this->equalTo(TRUE))
                      ->will($this->returnSelf());

        $this->class->order_by('col');
    }

    /**
     * Test limit().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::limit
     */
    public function testLimit()
    {
        $this->escaper->expects($this->at(0))
                      ->method('intvalue')
                      ->with($this->equalTo(10))
                      ->will($this->returnValue(10));

        $this->escaper->expects($this->at(1))
                      ->method('intvalue')
                      ->with($this->equalTo(-1))
                      ->will($this->returnValue(-1));

        $this->builder->expects($this->once())
                      ->method('limit')
                      ->with($this->equalTo(10))
                      ->will($this->returnSelf());

        $this->class->limit(10);
    }

    /**
     * Test union().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::union
     */
    public function testUnion()
    {
        $this->escaper->expects($this->once())
                      ->method('query_value')
                      ->with($this->equalTo('query'))
                      ->will($this->returnValue('(query)'));

        $this->builder->expects($this->once())
                      ->method('union')
                      ->with($this->equalTo('(query)'))
                      ->will($this->returnSelf());

        $this->class->union('query');
    }

     /**
     * Test union() all.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::union
     */
    public function testUnionAll()
    {
        $this->escaper->expects($this->once())
                      ->method('query_value')
                      ->with($this->equalTo('query'))
                      ->will($this->returnValue('(query)'));

        $this->builder->expects($this->once())
                      ->method('union')
                      ->with($this->equalTo('(query)', TRUE), $this->equalTo(TRUE))
                      ->will($this->returnSelf());

        $this->class->union('query', TRUE);
    }

}

?>
