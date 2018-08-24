<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderDeleteTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\Tests\MariaDBSimpleDMLQueryBuilderTest;
use ReflectionClass;

/**
 * This class contains the delete tests for the MariaDBSimpleDMLQueryBuilder class
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder
 */
class MariaDBSimpleDMLQueryBuilderDeleteTest extends MariaDBSimpleDMLQueryBuilderTest
{

    /**
     * Test returning with a single column.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder::returning
     */
    public function testDeleteReturningSingleColumn()
    {
        $this->escaper->expects($this->once())
                      ->method('result_column')
                      ->with($this->equalTo('id'))
                      ->will($this->returnValue('`id`'));

        $this->builder->expects($this->once())
                      ->method('returning')
                      ->with($this->equalTo('`id`'))
                      ->will($this->returnSelf());

        $this->class->returning('id');
    }

    /**
     * Test returning with multiple columns.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder::returning
     */
    public function testDeleteReturningMultipleColumns()
    {
        $this->escaper->expects($this->exactly(2))
                      ->method('result_column')
                      ->will($this->onConsecutiveCalls('`id`', '`name`'));

        $this->builder->expects($this->once())
                      ->method('returning')
                      ->with($this->equalTo('`id`, `name`'))
                      ->will($this->returnSelf());

        $this->class->returning('id, name');
    }

}

?>
