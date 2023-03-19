<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderFluidInterfaceTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testIntoReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('into')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->into('table');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of column_names().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::column_names
     */
    public function testColumnNamesReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('column_names')
                      ->with($this->equalTo([ 0 => NULL ]))
                      ->will($this->returnSelf());

        $return = $this->class->column_names([ 'col' ]);

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of select().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select
     */
    public function testSelectReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('select')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->select('col');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of from().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::from
     */
    public function testFromReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('from')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->from('table');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of join().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::join
     */
    public function testJoinReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('join')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->join('table');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on
     */
    public function testOnReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('on')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on('left', 'right');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('on_like')
                      ->with($this->equalTo(NULL), $this->equalTo('right'))
                      ->will($this->returnSelf());

        $return = $this->class->on_like('left', 'right');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('on_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_in('col', [ 'val' ]);

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('on_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_between('col', 'upper', 'lower');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('on_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->on_regexp('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of start_on_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::start_on_group
     */
    public function testStartOnGroupReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('start_on_group')
                      ->will($this->returnSelf());

        $return = $this->class->start_on_group();

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of end_on_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::end_on_group
     */
    public function testEndOnGroupReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('end_on_group')
                      ->will($this->returnSelf());

        $return = $this->class->end_on_group();

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of start_having_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::start_having_group
     */
    public function testStartHavingGroupReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('start_having_group')
                      ->will($this->returnSelf());

        $return = $this->class->start_having_group();

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of end_having_group().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::end_having_group
     */
    public function testEndHavingGroupReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('end_having_group')
                      ->will($this->returnSelf());

        $return = $this->class->end_having_group();

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where
     */
    public function testWhereReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('where')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('where_like')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_like('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('where_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_in('col', [ 'val' ]);

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('where_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_between('col', 'lower', 'upper');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('where_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->where_regexp('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of group_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('group_by')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->group_by('col');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having
     */
    public function testHavingReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('having')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('having_like')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_like('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('having_in')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_in('col', [ 'val' ]);

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('having_between')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_between('col', 'lower', 'upper');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('having_regexp')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->having_regexp('col', 'val');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of order_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('order_by')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->order_by('col');

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of limit().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelf(): void
    {
        $this->builder->expects($this->once())
                      ->method('limit')
                      ->with($this->equalTo(NULL))
                      ->will($this->returnSelf());

        $return = $this->class->limit(10);

        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_duplicate_key_update().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_duplicate_key_update
     */
    public function testOnDuplicateKeyUpdate()
    {
        $this->builder->expects($this->once())
                      ->method('on_duplicate_key_update')
                      ->with('col=col+1')
                      ->will($this->returnSelf());

        $return = $this->class->on_duplicate_key_update('col=col+1');

        $this->assertSame($this->class, $return);
    }

}

?>
