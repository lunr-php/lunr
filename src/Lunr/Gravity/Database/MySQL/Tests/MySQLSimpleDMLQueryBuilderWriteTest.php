<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderWriteTest class.
 *
 * PHP Version 5.4
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains select tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderWriteTest extends MySQLSimpleDMLQueryBuilderTest
{

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

        $this->class->column_names([ 'col' ]);

        $this->assertEquals('(`col`)', $this->get_reflection_property_value('column_names'));
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

        $this->class->column_names([ 'col1', 'col2' ]);

        $this->assertEquals('(`col1`, `col2`)', $this->get_reflection_property_value('column_names'));
    }

}

?>
