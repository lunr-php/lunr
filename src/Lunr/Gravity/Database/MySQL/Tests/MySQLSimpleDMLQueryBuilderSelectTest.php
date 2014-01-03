<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderSelectTest class.
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
class MySQLSimpleDMLQueryBuilderSelectTest extends MySQLSimpleDMLQueryBuilderTest
{

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

        $this->class->select('col');

        $this->assertEquals('`col`', $this->get_reflection_property_value('select'));
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

        $this->class->select('col, col');

        $this->assertEquals('`col`, `col`', $this->get_reflection_property_value('select'));
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

        $this->class->from('table');

        $this->assertEquals('FROM `table`', $this->get_reflection_property_value('from'));
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

        $this->class->join('table');

        $this->assertEquals('INNER JOIN `table`', $this->get_reflection_property_value('join'));
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

        $this->class->group_by('col');

        $this->assertEquals('GROUP BY `col`', $this->get_reflection_property_value('group_by'));
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

        $this->class->order_by('col');

        $this->assertEquals('ORDER BY `col` ASC', $this->get_reflection_property_value('order_by'));
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

        $this->class->limit(10);

        $this->assertEquals('LIMIT 10', $this->get_reflection_property_value('limit'));
    }

}

?>
