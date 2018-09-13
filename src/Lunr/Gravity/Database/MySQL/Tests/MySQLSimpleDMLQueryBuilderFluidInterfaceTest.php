<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderFluidInterfaceTest class.
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
class MySQLSimpleDMLQueryBuilderFluidInterfaceTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test the fluid interface of into().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::into
     */
    public function testIntoReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('into')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $this->class->into('table');
    }

    /**
     * Test the fluid interface of column_names().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo([0 => NULL]))
                      ->will($this->returnSelf());

        $this->class->column_names([ 'col' ]);
    }

    /**
     * Test the fluid interface of select().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select
     */
    public function testSelectReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('select')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->select('col');
    }

    /**
     * Test the fluid interface of from().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::from
     */
    public function testFromReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('from')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->from('table');
    }

    /**
     * Test the fluid interface of join().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::join
     */
    public function testJoinReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('join')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->join('table');
    }

    /**
     * Test the fluid interface of on().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on
     */
    public function testOnReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('on')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on('left', 'right');
    }

    /**
     * Test the fluid interface of on_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('on_like')
                      ->with($this->equalTo(NULL), $this->equalTo('right'))
                      ->will($this->returnSelf());

        $return = $this->class->on_like('left', 'right');
    }

    /**
     * Test the fluid interface of on_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('on_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_in('col', [ 'val' ]);
    }

    /**
     * Test the fluid interface of on_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('on_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_between('col', 'upper', 'lower');
    }

    /**
     * Test the fluid interface of on_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('on_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_regexp('col', 'val');
    }

    /**
     * Test the fluid interface of start_on_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::start_on_group
     */
    public function testStartOnGroupReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('start_on_group')
                      ->will($this->returnSelf());

        $return = $this->class->start_on_group();
    }

    /**
     * Test the fluid interface of end_on_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::end_on_group
     */
    public function testEndOnGroupReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('end_on_group')
                      ->will($this->returnSelf());

        $return = $this->class->end_on_group();
    }

    /**
     * Test the fluid interface of start_having_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::start_having_group
     */
    public function testStartHavingGroupReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('start_having_group')
                      ->will($this->returnSelf());

        $return = $this->class->start_having_group();
    }

    /**
     * Test the fluid interface of end_having_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::end_having_group
     */
    public function testEndHavingGroupReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('end_having_group')
                      ->will($this->returnSelf());

        $return = $this->class->end_having_group();
    }

    /**
     * Test the fluid interface of where().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where
     */
    public function testWhereReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('where')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where('col', 'val');
    }

    /**
     * Test the fluid interface of where_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('where_like')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_like('col', 'val');
    }

    /**
     * Test the fluid interface of where_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('where_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_in('col', [ 'val' ]);
    }

    /**
     * Test the fluid interface of where_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('where_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_between('col', 'lower', 'upper');
    }

    /**
     * Test the fluid interface of where_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('where_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_regexp('col', 'val');
    }

    /**
     * Test the fluid interface of group_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('group_by')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->group_by('col');
    }

    /**
     * Test the fluid interface of having().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having
     */
    public function testHavingReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('having')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having('col', 'val');
    }

    /**
     * Test the fluid interface of having_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('having_like')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_like('col', 'val');
    }

    /**
     * Test the fluid interface of having_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('having_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_in('col', [ 'val' ]);
    }

    /**
     * Test the fluid interface of having_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('having_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_between('col', 'lower', 'upper');
    }

    /**
     * Test the fluid interface of having_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('having_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_regexp('col', 'val');
    }

    /**
     * Test the fluid interface of order_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('order_by')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->order_by('col');
    }

    /**
     * Test the fluid interface of limit().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelf()
    {
        $this->builder->expects($this->once())
                      ->method('limit')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->limit(10);
    }

}

?>
