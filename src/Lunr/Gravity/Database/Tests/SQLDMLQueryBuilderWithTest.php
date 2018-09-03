<?php
/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsWithTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Koen Hengsdijk
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\SQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * with statements.
 *
 * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderWithTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the WITH part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsWithTest::testNonRecursiveWithWithoutColumnNames
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testWith()
    {
        $this->class->with('alias', 'query');
        $value = $this->get_reflection_property_value('with');

        $this->assertEquals('alias AS ( query )', $value);
    }

    /**
     * Test fluid interface of the with method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::with
     */
    public function testWithReturnsSelfReference()
    {
        $return = $this->class->with('alias', 'query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the WITH part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsWithTest::testRecursiveWithWithoutColumnNames
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testWith_recursive()
    {
        $this->class->with_recursive('alias', 'anchor_query', 'recursive_query');
        $value = $this->get_reflection_property_value('with');

        $this->assertEquals('alias AS ( anchor_query UNION recursive_query )', $value);
    }

    /**
     * Test fluid interface of the with method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::with
     */
    public function testWithRecursiveReturnsSelfReference()
    {
        $return = $this->class->with_recursive('alias', 'anchor_query', 'recursive_query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
