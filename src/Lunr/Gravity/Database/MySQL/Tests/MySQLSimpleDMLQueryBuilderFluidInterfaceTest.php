<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderFluidInterfaceTest class.
 *
 * PHP Version 5.4
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;
use ReflectionClass;

/**
 * This class contains select tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderFluidInterfaceTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test the fluid interface of select().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::select
     */
    public function testSelectReturnsSelf()
    {
        $return = $this->class->select('col');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of from().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::from
     */
    public function testFromReturnsSelf()
    {
        $return = $this->class->from('table');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of join().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::join
     */
    public function testJoinReturnsSelf()
    {
        $return = $this->class->join('table');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on
     */
    public function testOnReturnsSelf()
    {
        $return = $this->class->on('left', 'right');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelf()
    {
        $return = $this->class->on_like('left', 'right');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelf()
    {
        $return = $this->class->on_in('col', ['val']);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelf()
    {
        $return = $this->class->on_between('col', 'upper', 'lower');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of on_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelf()
    {
        $return = $this->class->on_regexp('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where
     */
    public function testWhereReturnsSelf()
    {
        $return = $this->class->where('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelf()
    {
        $return = $this->class->where_like('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelf()
    {
        $return = $this->class->where_in('col', ['val']);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelf()
    {
        $return = $this->class->where_between('col', 'lower', 'upper');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of where_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelf()
    {
        $return = $this->class->where_regexp('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of group_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelf()
    {
        $return = $this->class->group_by('col');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having
     */
    public function testHavingReturnsSelf()
    {
        $return = $this->class->having('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_like().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelf()
    {
        $return = $this->class->having_like('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_in().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelf()
    {
        $return = $this->class->having_in('col', ['val']);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_between().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelf()
    {
        $return = $this->class->having_between('col', 'lower', 'upper');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of having_regexp().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelf()
    {
        $return = $this->class->having_regexp('col', 'val');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of order_by().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelf()
    {
        $return = $this->class->order_by('col');
        $this->assertSame($this->class, $return);
    }

    /**
     * Test the fluid interface of limit().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelf()
    {
        $return = $this->class->limit(10);
        $this->assertSame($this->class, $return);
    }

}

?>
