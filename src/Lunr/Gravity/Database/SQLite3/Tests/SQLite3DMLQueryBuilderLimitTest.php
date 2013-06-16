<?php

/**
 * This file contains the SQLite3DMLQueryBuilderLimitTest class.
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
 * limit statements.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderLimitTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the limit part of a query with default offset.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::limit
     */
    public function testLimitWithDefaultOffset()
    {
        $this->class->limit(10);
        $value = $this->get_reflection_property_value('limit');

        $this->assertEquals('LIMIT 10', $value);
    }

    /**
     * Test specifying the limit part of a query with custom offset.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::limit
     */
    public function testLimitWithCustomOffset()
    {
        $this->class->limit(10, 20);
        $value = $this->get_reflection_property_value('limit');

        $this->assertEquals('LIMIT 10 OFFSET 20', $value);
    }

    /**
     * Test fluid interface of the limit method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::limit
     */
    public function testLimitReturnsSelfReference()
    {
        $return = $this->class->limit(10);

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
