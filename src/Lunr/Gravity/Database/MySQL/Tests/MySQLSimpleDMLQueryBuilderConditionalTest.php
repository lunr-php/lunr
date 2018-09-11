<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderConditionalTest class.
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
 * This class contains conditional tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderConditionalTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test on().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on
     */
    public function testOn()
    {
        $this->escaper->expects($this->at(0))
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->at(1))
                      ->method('column')
                      ->with($this->equalTo('right'))
                      ->will($this->returnValue('`right`'));

        $this->builder->expects($this->once())
                      ->method('on')
                      ->with($this->equalTo('`left`'), $this->equalTo('`right`'))
                      ->will($this->returnSelf());

        $this->class->on('left', 'right');
    }

    /**
     * Test on_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_like
     */
    public function testOnLike()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('on_like')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->on_like('left', 'right');
    }

    /**
     * Test on_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_in
     */
    public function testOnIn()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->once())
                      ->method('list_value')
                      ->with($this->equalTo([ 'val1', 'val2' ]))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->builder->expects($this->once())
                      ->method('on_in')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->on_in('left', [ 'val1', 'val2' ]);
    }

    /**
     * Test on_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_between
     */
    public function testOnBetween()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->at(1))
                      ->method('value')
                      ->with($this->equalTo('a'))
                      ->will($this->returnValue('"a"'));

        $this->escaper->expects($this->at(2))
                      ->method('value')
                      ->with($this->equalTo('b'))
                      ->will($this->returnValue('"b"'));

        $this->builder->expects($this->once())
                      ->method('on_between')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->on_between('left', 'a', 'b');
    }

    /**
     * Test on_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_regexp
     */
    public function testOnRegexp()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('on_regexp')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->on_regexp('left', 'right');
    }

    /**
     * Test on_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_null
     */
    public function testOnNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('on_null')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->on_null('left');
    }

    /**
     * Test negate on_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_null
     */
    public function testOnNotNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('on_null')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnValue($this->builder));

        $this->class->on_null('left', TRUE);
    }

    /**
     * Test where().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where
     */
    public function testWhere()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('right'))
                      ->will($this->returnValue('"right"'));

        $this->builder->expects($this->once())
                      ->method('where')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->where('left', 'right');
    }

    /**
     * Test start_where_group() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::start_where_group
     */
    public function testStartWhereGroup()
    {
        $this->builder->expects($this->once())
                      ->method('sql_group_start')
                      ->will($this->returnSelf());

        $this->class->start_where_group();
    }

    /**
     * Test end_where_group() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::end_where_group
     */
    public function testEndWhereGroup()
    {
        $this->builder->expects($this->once())
                      ->method('sql_group_end')
                      ->will($this->returnSelf());

        $this->class->end_where_group();
    }

    /**
     * Test sql_or() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::sql_or
     */
    public function testSqlOr()
    {
        $this->builder->expects($this->once())
                      ->method('sql_or')
                      ->will($this->returnSelf());

        $this->class->sql_or();
    }

    /**
     * Test sql_and() gets called correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::sql_and
     */
    public function testSqlAnd()
    {
        $this->builder->expects($this->once())
                      ->method('sql_and')
                      ->will($this->returnSelf());

        $this->class->sql_and();
    }

    /**
     * Test where_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_like
     */
    public function testWhereLike()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('where_like')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->where_like('left', 'right');
    }

    /**
     * Test where_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_in
     */
    public function testWhereIn()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->once())
                      ->method('list_value')
                      ->with($this->equalTo([ 'val1', 'val2' ]))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->builder->expects($this->once())
                      ->method('where_in')
                      ->with($this->equalTo('`left`'), $this->equalTo('("val1", "val2")'), FALSE)
                      ->will($this->returnSelf());

        $this->class->where_in('left', [ 'val1', 'val2' ]);
    }

    /**
     * Test where_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_between
     */
    public function testWhereBetween()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->at(1))
                      ->method('value')
                      ->with($this->equalTo('a'))
                      ->will($this->returnValue('"a"'));

        $this->escaper->expects($this->at(2))
                      ->method('value')
                      ->with($this->equalTo('b'))
                      ->will($this->returnValue('"b"'));

        $this->builder->expects($this->once())
                      ->method('where_between')
                      ->with($this->equalTo('`left`'), $this->equalTo('"a"'), $this->equalTo('"b"'))
                      ->will($this->returnSelf());

        $this->class->where_between('left', 'a', 'b');
    }

    /**
     * Test where_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexp()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('where_regexp')
                      ->with($this->equalTo('`left`'), $this->equalTo('right'))
                      ->will($this->returnSelf());

        $this->class->where_regexp('left', 'right');
    }

    /**
     * Test where_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_null
     */
    public function testWhereNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('where_null')
                      ->with($this->equalTo('`left`'))
                      ->will($this->returnSelf());

        $this->class->where_null('left');
    }

    /**
     * Test negate where_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_null
     */
    public function testWhereNotNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('where_null')
                      ->with($this->equalTo('`left`'), $this->equalTo(TRUE))
                      ->will($this->returnSelf());

        $this->class->where_null('left', TRUE);
    }

    /**
     * Test having().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having
     */
    public function testHaving()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->once())
                      ->method('value')
                      ->with($this->equalTo('right'))
                      ->will($this->returnValue('"right"'));

        $this->builder->expects($this->once())
                      ->method('having')
                      ->with($this->equalTo('`left`'), $this->equalTo('"right"'))
                      ->will($this->returnSelf());

        $this->class->having('left', 'right');
    }

    /**
     * Test having_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_like
     */
    public function testHavingLike()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('having_like')
                      ->with($this->equalTo('`left`'), $this->equalTo('right'))
                      ->will($this->returnSelf());

        $this->class->having_like('left', 'right');
    }

    /**
     * Test having_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_in
     */
    public function testHavingIn()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->once())
                      ->method('list_value')
                      ->with($this->equalTo([ 'val1', 'val2' ]))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->builder->expects($this->once())
                      ->method('having_in')
                      ->with($this->equalTo('`left`'), $this->equalTo('("val1", "val2")'), FALSE)
                      ->will($this->returnSelf());

        $this->class->having_in('left', [ 'val1', 'val2' ]);
    }

    /**
     * Test having_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_between
     */
    public function testHavingBetween()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->escaper->expects($this->at(1))
                      ->method('value')
                      ->with($this->equalTo('a'))
                      ->will($this->returnValue('"a"'));

        $this->escaper->expects($this->at(2))
                      ->method('value')
                      ->with($this->equalTo('b'))
                      ->will($this->returnValue('"b"'));

        $this->builder->expects($this->once())
                      ->method('having_between')
                      ->with($this->equalTo('`left`'), $this->equalTo('"a"'), $this->equalTo('"b"'))
                      ->will($this->returnSelf());

        $this->class->having_between('left', 'a', 'b');
    }

    /**
     * Test having_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexp()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('having_regexp')
                      ->with($this->equalTo('`left`'), $this->equalTo('right'))
                      ->will($this->returnSelf());

        $this->class->having_regexp('left', 'right');
    }

    /**
     * Test having_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_null
     */
    public function testHavingNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('having_null')
                      ->with($this->equalTo('`left`'), $this->equalTo(FALSE))
                      ->will($this->returnSelf());

        $this->class->having_null('left');
    }

    /**
     * Test negate having_null().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_null
     */
    public function testHavingNotNull()
    {
        $this->escaper->expects($this->once())
                      ->method('column')
                      ->with($this->equalTo('left'))
                      ->will($this->returnValue('`left`'));

        $this->builder->expects($this->once())
                      ->method('having_null')
                      ->with($this->equalTo('`left`'), $this->equalTo(TRUE))
                      ->will($this->returnSelf());

        $this->class->having_null('left', TRUE);
    }

}

?>
