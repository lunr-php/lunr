<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderUsingTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
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
class MySQLSimpleDMLQueryBuilderUsingTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::using
     */
    public function testUsing()
    {
        $this->escaper->expects($this->once())
             ->method('column')
             ->with($this->equalTo('column1'))
             ->will($this->returnValue('`column1`'));

        $this->builder->expects($this->once())
             ->method('using')
             ->with($this->equalTo('`column1`'))
             ->will($this->returnSelf());

        $this->class->join('table2');
        $this->class->using('column1');
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::using
     */
    public function testUsingAddSecondColumn()
    {
        $this->escaper->expects($this->once())
             ->method('table')
             ->with($this->equalTo('table2'))
             ->will($this->returnValue('`table2`'));

        $this->escaper->expects($this->at(1))
             ->method('column')
             ->with($this->equalTo('column1'))
             ->will($this->returnValue('`column1`'));

        $this->escaper->expects($this->at(2))
             ->method('column')
             ->with($this->equalTo('column2'))
             ->will($this->returnValue('`column2`'));

        $this->builder->expects($this->exactly(2))
             ->method('using')
             ->will($this->returnSelf());

        $this->class->join('table2');
        $this->class->using('column1');
        $this->class->using('column2');
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::using
     */
    public function testUsingMultipleColumn()
    {
        $this->escaper->expects($this->at(0))
             ->method('table')
             ->with($this->equalTo('table2'))
             ->will($this->returnValue('`table2`'));

        $this->escaper->expects($this->at(1))
             ->method('column')
             ->with($this->equalTo('column1'))
             ->will($this->returnValue('`column1`'));

        $this->escaper->expects($this->at(2))
             ->method('column')
             ->with($this->equalTo('column2'))
             ->will($this->returnValue('`column2`'));

        $this->builder->expects($this->once())
             ->method('using')
             ->with($this->equalTo('`column1`, `column2`'))
             ->will($this->returnSelf());

        $this->class->join('table2');
        $this->class->using('column1, column2');
    }

}

?>
