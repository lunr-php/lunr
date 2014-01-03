<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderConditionalTest class.
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
 * This class contains conditional tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
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

        $this->class->on('left', 'right');

        $this->assertEquals('ON `left` = `right`', $this->get_reflection_property_value('join'));
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

        $this->class->on_like('left', 'right');

        $this->assertEquals('ON `left` LIKE right', $this->get_reflection_property_value('join'));
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
                      ->with($this->equalTo(['val1', 'val2']))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->class->on_in('left', ['val1', 'val2']);

        $this->assertEquals('ON `left` IN ("val1", "val2")', $this->get_reflection_property_value('join'));
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

        $this->class->on_between('left', 'a', 'b');

        $this->assertEquals('ON `left` BETWEEN "a" AND "b"', $this->get_reflection_property_value('join'));
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

        $this->class->on_regexp('left', 'right');

        $this->assertEquals('ON `left` REGEXP right', $this->get_reflection_property_value('join'));
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

        $this->class->where('left', 'right');

        $this->assertEquals('WHERE `left` = "right"', $this->get_reflection_property_value('where'));
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

        $this->class->where_like('left', 'right');

        $this->assertEquals('WHERE `left` LIKE right', $this->get_reflection_property_value('where'));
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
                      ->with($this->equalTo(['val1', 'val2']))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->class->where_in('left', ['val1', 'val2']);

        $this->assertEquals('WHERE `left` IN ("val1", "val2")', $this->get_reflection_property_value('where'));
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

        $this->class->where_between('left', 'a', 'b');

        $this->assertEquals('WHERE `left` BETWEEN "a" AND "b"', $this->get_reflection_property_value('where'));
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

        $this->class->where_regexp('left', 'right');

        $this->assertEquals('WHERE `left` REGEXP right', $this->get_reflection_property_value('where'));
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

        $this->class->having('left', 'right');

        $this->assertEquals('HAVING `left` = "right"', $this->get_reflection_property_value('having'));
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

        $this->class->having_like('left', 'right');

        $this->assertEquals('HAVING `left` LIKE right', $this->get_reflection_property_value('having'));
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
                      ->with($this->equalTo(['val1', 'val2']))
                      ->will($this->returnValue('("val1", "val2")'));

        $this->class->having_in('left', ['val1', 'val2']);

        $this->assertEquals('HAVING `left` IN ("val1", "val2")', $this->get_reflection_property_value('having'));
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

        $this->class->having_between('left', 'a', 'b');

        $this->assertEquals('HAVING `left` BETWEEN "a" AND "b"', $this->get_reflection_property_value('having'));
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

        $this->class->having_regexp('left', 'right');

        $this->assertEquals('HAVING `left` REGEXP right', $this->get_reflection_property_value('having'));
    }

}

?>
