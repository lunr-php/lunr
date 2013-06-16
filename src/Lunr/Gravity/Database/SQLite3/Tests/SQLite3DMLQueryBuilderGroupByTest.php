<?php

/**
 * This file contains the SQLite3DMLQueryBuilderGroupByTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * group by statement.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderGroupByTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the group by part of a query with default order.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::group_by
     */
    public function testGroupByWithDefaultOrder()
    {
        $this->class->group_by('group1');
        $value = $this->get_reflection_property_value('group_by');

        $this->assertEquals('GROUP BY group1', $value);
    }

    /**
     * Test specifying the group by part of a query with custom order.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::group_by
     */
    public function testGroupByIgnoresCustomOrder()
    {
        $this->class->group_by('group1', FALSE);
        $value = $this->get_reflection_property_value('group_by');
        $this->assertEquals('GROUP BY group1', $value);

        $this->class->group_by('group2', TRUE);
        $value = $this->get_reflection_property_value('group_by');
        $this->assertEquals('GROUP BY group1, group2', $value);
    }

    /**
     * Test fluid interface of the group by method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::group_by
     */
    public function testGroupByReturnsSelfReference()
    {
        $return = $this->class->group_by('group1');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
