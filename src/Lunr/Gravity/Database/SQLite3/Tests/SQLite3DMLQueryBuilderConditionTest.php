<?php

/**
 * This file contains the SQLite3DMLQueryBuilderConditionTest class.
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
 * where/having statements.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderConditionTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on
     */
    public function testOnWithDefaultOperator()
    {
        $this->class->on('left', 'right');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left = right', $value);
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on
     */
    public function testOnWithCustomOperator()
    {
        $this->class->on('left', 'right', '>');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left > right', $value);
    }

    /**
     * Test fluid interface of the on method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on
     */
    public function testOnReturnsSelfReference()
    {
        $return = $this->class->on('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_like
     */
    public function testOnLike()
    {
        $this->class->on_like('left', 'right');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left LIKE right', $value);
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_like
     */
    public function testOnNotLike()
    {
        $this->class->on_like('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left NOT LIKE right', $value);
    }

    /**
     * Test fluid interface of the on_like method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelfReference()
    {
        $return = $this->class->on_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_in
     */
    public function testOnIn()
    {
        $this->class->on_in('left', 'right');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left IN right', $value);
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_in
     */
    public function testOnNotIn()
    {
        $this->class->on_in('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left NOT IN right', $value);
    }

    /**
     * Test fluid interface of the on_in method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelfReference()
    {
        $return = $this->class->on_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_between
     */
    public function testOnBetween()
    {
        $this->class->on_between('left', 'lower', 'upper');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left BETWEEN lower AND upper', $value);
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_between
     */
    public function testOnNotBetween()
    {
        $this->class->on_between('left', 'lower', 'upper', TRUE);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left NOT BETWEEN lower AND upper', $value);
    }

    /**
     * Test fluid interface of the on_between method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelfReference()
    {
        $return = $this->class->on_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_regexp
     */
    public function testOnRegexp()
    {
        $this->class->on_regexp('left', 'right');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left REGEXP right', $value);
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_regexp
     */
    public function testOnNotRegexp()
    {
        $this->class->on_regexp('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('ON left NOT REGEXP right', $value);
    }

    /**
     * Test fluid interface of the on_regexp method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_regexp
     */
    public function testOnRegexpReturnsSelfReference()
    {
        $return = $this->class->on_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where
     */
    public function testWhereWithDefaultOperator()
    {
        $this->class->where('left', 'right');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left = right', $value);
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where
     */
    public function testWhereWithCustomOperator()
    {
        $this->class->where('left', 'right', '>');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left > right', $value);
    }

    /**
     * Test fluid interface of the where method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where
     */
    public function testWhereReturnsSelfReference()
    {
        $return = $this->class->where('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_like
     */
    public function testWhereLike()
    {
        $this->class->where_like('left', 'right');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left LIKE right', $value);
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_like
     */
    public function testWhereNotLike()
    {
        $this->class->where_like('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left NOT LIKE right', $value);
    }

    /**
     * Test fluid interface of the where_like method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelfReference()
    {
        $return = $this->class->where_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_in
     */
    public function testWhereIn()
    {
        $this->class->where_in('left', 'right');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left IN right', $value);
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_in
     */
    public function testWhereNotIn()
    {
        $this->class->where_in('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left NOT IN right', $value);
    }

    /**
     * Test fluid interface of the where_in method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelfReference()
    {
        $return = $this->class->where_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_between
     */
    public function testWhereBetween()
    {
        $this->class->where_between('left', 'lower', 'upper');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left BETWEEN lower AND upper', $value);
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_between
     */
    public function testWhereNotBetween()
    {
        $this->class->where_between('left', 'lower', 'upper', TRUE);
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left NOT BETWEEN lower AND upper', $value);
    }

    /**
     * Test fluid interface of the where_between method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelfReference()
    {
        $return = $this->class->where_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_regexp
     */
    public function testWhereRegexp()
    {
        $this->class->where_regexp('left', 'right');
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left REGEXP right', $value);
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_regexp
     */
    public function testWhereNotRegexp()
    {
        $this->class->where_regexp('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('where');

        $this->assertEquals('WHERE left NOT REGEXP right', $value);
    }

    /**
     * Test fluid interface of the where_regexp method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_regexp
     */
    public function testWhereRegexpReturnsSelfReference()
    {
        $return = $this->class->where_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having
     */
    public function testHavingWithDefaultOperator()
    {
        $this->class->having('left', 'right');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left = right', $value);
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having
     */
    public function testHavingWithCustomOperator()
    {
        $this->class->having('left', 'right', '>');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left > right', $value);
    }

    /**
     * Test fluid interface of the having method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having
     */
    public function testHavingReturnsSelfReference()
    {
        $return = $this->class->having('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_like
     */
    public function testHavingLike()
    {
        $this->class->having_like('left', 'right');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left LIKE right', $value);
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_like
     */
    public function testHavingNotLike()
    {
        $this->class->having_like('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left NOT LIKE right', $value);
    }

    /**
     * Test fluid interface of the having_like method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelfReference()
    {
        $return = $this->class->having_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_in
     */
    public function testHavingIn()
    {
        $this->class->having_in('left', 'right');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left IN right', $value);
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_in
     */
    public function testHavingNotIn()
    {
        $this->class->having_in('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left NOT IN right', $value);
    }

    /**
     * Test fluid interface of the having_in method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelfReference()
    {
        $return = $this->class->having_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_between
     */
    public function testHavingBetween()
    {
        $this->class->having_between('left', 'lower', 'upper');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left BETWEEN lower AND upper', $value);
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_between
     */
    public function testHavingNotBetween()
    {
        $this->class->having_between('left', 'lower', 'upper', TRUE);
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left NOT BETWEEN lower AND upper', $value);
    }

    /**
     * Test fluid interface of the having_between method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelfReference()
    {
        $return = $this->class->having_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_regexp
     */
    public function testHavingRegexp()
    {
        $this->class->having_regexp('left', 'right');
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left REGEXP right', $value);
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_regexp
     */
    public function testHavingNotRegexp()
    {
        $this->class->having_regexp('left', 'right', TRUE);
        $value = $this->get_reflection_property_value('having');

        $this->assertEquals('HAVING left NOT REGEXP right', $value);
    }

    /**
     * Test fluid interface of the having_regexp method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_regexp
     */
    public function testHavingRegexpReturnsSelfReference()
    {
        $return = $this->class->having_regexp('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying a logical AND connector.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::sql_and
     */
    public function testSQLAnd()
    {
        $this->class->sql_and();

        $value = $this->get_reflection_property_value('connector');

        $this->assertEquals('AND', $value);
    }

    /**
     * Test fluid interface of the sql_and method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::sql_and
     */
    public function testSQLAndReturnsSelfReference()
    {
        $return = $this->class->sql_and();

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying a logical OR connector.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::sql_or
     */
    public function testSQLOr()
    {
        $this->class->sql_or();

        $value = $this->get_reflection_property_value('connector');

        $this->assertEquals('OR', $value);
    }

    /**
     * Test fluid interface of the sql_or method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::sql_or
     */
    public function testSQLOrReturnsSelfReference()
    {
        $return = $this->class->sql_or();

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
