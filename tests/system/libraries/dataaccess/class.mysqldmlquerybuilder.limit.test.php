<?php

/**
 * This file contains the MySQLDMLQueryBuilderLimitTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts necessary to build
 * limit statements.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderLimitTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the limit part of a query with default offset.
     *
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::limit
     */
    public function testLimitWithDefaultOffset()
    {
        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $this->builder->limit(10);

        $this->assertEquals('LIMIT 10', $property->getValue($this->builder));
    }

    /**
     * Test specifying the limit part of a query with custom offset.
     *
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::limit
     */
    public function testLimitWithCustomOffset()
    {
        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $this->builder->limit(10, 20);

        $this->assertEquals('LIMIT 10 OFFSET 20', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the limit method.
     *
     * @covers  Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder::limit
     */
    public function testLimitReturnsSelfReference()
    {
        $return = $this->builder->limit(10);

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>