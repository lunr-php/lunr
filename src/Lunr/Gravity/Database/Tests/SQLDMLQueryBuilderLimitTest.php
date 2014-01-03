<?php

/**
 * This file contains the SQLDMLQueryBuilderLimitTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * limit statements.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderLimitTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the limit part of a query with default offset.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
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
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
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
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelfReference()
    {
        $return = $this->class->limit(10);

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
