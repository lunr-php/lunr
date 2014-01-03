<?php

/**
 * This file contains the MySQLDMLQueryBuilderConditionTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * where/having statements.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderConditionTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::on_regexp
     */
    public function testOnRegexp()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_regexp('left', 'right');

        $this->assertEquals('ON left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::on_regexp
     */
    public function testOnNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->on_regexp('left', 'right', TRUE);

        $this->assertEquals('ON left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the on_regexp method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelfReference()
    {
        $return = $this->builder->on_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexp()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_regexp('left', 'right');

        $this->assertEquals('WHERE left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::where_regexp
     */
    public function testWhereNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('where');
        $property->setAccessible(TRUE);

        $this->builder->where_regexp('left', 'right', TRUE);

        $this->assertEquals('WHERE left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the where_regexp method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelfReference()
    {
        $return = $this->builder->where_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexp()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_regexp('left', 'right');

        $this->assertEquals('HAVING left REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::having_regexp
     */
    public function testHavingNotRegexp()
    {
        $property = $this->builder_reflection->getProperty('having');
        $property->setAccessible(TRUE);

        $this->builder->having_regexp('left', 'right', TRUE);

        $this->assertEquals('HAVING left NOT REGEXP right', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the having_regexp method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelfReference()
    {
        $return = $this->builder->having_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying a logical XOR connector.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::sql_xor
     */
    public function testSQLXor()
    {
        $property = $this->builder_reflection->getProperty('connector');
        $property->setAccessible(TRUE);

        $this->builder->sql_xor();

        $this->assertEquals('XOR', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the sql_xor method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::sql_xor
     */
    public function testSQLXorReturnsSelfReference()
    {
        $return = $this->builder->sql_xor();

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
