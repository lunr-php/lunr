<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderDeleteTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Brian Stoop <b.stoop@m2mobi.com>
 * @copyright  2013-2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains select tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderDeleteTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test delete() with one input column.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::delete
     */
    public function testDeleteWithOneColumn(): void
    {
        $this->escaper->expects($this->once())
                      ->method('table')
                      ->with($this->equalTo('col'))
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('delete')
                      ->with($this->equalTo('`col`'))
                      ->will($this->returnSelf());

        $this->class->delete('col');
    }

    /**
     * Test delete() with multiple input columns.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::delete
     */
    public function testDeleteWithMultipleColumns(): void
    {
        $this->escaper->expects($this->exactly(2))
                      ->method('table')
                      ->withConsecutive([ 'col' ], [ ' col' ])
                      ->will($this->returnValue('`col`'));

        $this->builder->expects($this->once())
                      ->method('delete')
                      ->with($this->equalTo('`col`, `col`'))
                      ->willReturn($this->returnSelf());

        $this->class->delete('col, col');
    }

}

?>
