<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderUsingTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
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
        $this->set_reflection_property_value('join', 'INNER JOIN `table2`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);

        $this->escaper->expects($this->once())
            ->method('column')
            ->with($this->equalTo('column1'))
            ->will($this->returnValue('`column1`'));

        $this->class->using('column1');

        $this->assertEquals('INNER JOIN `table2` USING (`column1`)', $this->get_reflection_property_value('join'));
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::using
     */
    public function testUsingAddSecondColumn()
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table2` USING (`column1`)');
        $this->set_reflection_property_value('is_unfinished_join', FALSE);

        $this->escaper->expects($this->at(0))
            ->method('column')
            ->with($this->equalTo('column2'))
            ->will($this->returnValue('`column2`'));

        $this->class->using('column2');

        $this->assertEquals('INNER JOIN `table2` USING (`column1`, `column2`)', $this->get_reflection_property_value('join'));
    }

    /**
     * Test using().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::using
     */
    public function testUsingMultipleColumn()
    {
        $this->set_reflection_property_value('join', 'INNER JOIN `table2`');
        $this->set_reflection_property_value('is_unfinished_join', TRUE);

        $this->escaper->expects($this->at(0))
            ->method('column')
            ->with($this->equalTo('column1'))
            ->will($this->returnValue('`column1`'));

        $this->escaper->expects($this->at(1))
            ->method('column')
            ->with($this->equalTo('column2'))
            ->will($this->returnValue('`column2`'));

        $this->class->using('column1, column2');

        $this->assertEquals('INNER JOIN `table2` USING (`column1`, `column2`)', $this->get_reflection_property_value('join'));
    }

}

?>
