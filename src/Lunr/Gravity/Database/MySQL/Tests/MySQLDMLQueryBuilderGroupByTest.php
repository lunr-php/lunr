<?php

/**
 * This file contains the MySQLDMLQueryBuilderGroupByTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * group by statement.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderGroupByTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the group by part of a query with default order.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByWithDefaultOrder()
    {
        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $this->builder->group_by('group1');

        $this->assertEquals('GROUP BY group1', $property->getValue($this->builder));
    }

    /**
     * Test specifying the group by part of a query with custom order.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByWithCustomOrder()
    {
        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $this->builder->group_by('group1', FALSE);

        $this->assertEquals('GROUP BY group1 DESC', $property->getValue($this->builder));

        $this->builder->group_by('group2', TRUE);

        $this->assertEquals('GROUP BY group1 DESC, group2 ASC', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the group by method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelfReference()
    {
        $return = $this->builder->group_by('group1');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
