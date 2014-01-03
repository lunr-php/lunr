<?php

/**
 * This file contains the SQLDMLQueryBuilderConditionTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * where/having statements.
 *
 * @category   SQL
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderConditionTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test grouping of ON condition (start group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::start_on_group
     */
    public function testOpeningGroupOn()
    {
        $this->class->start_on_group();
        $this->assertPropertyEquals('join', '(');
    }

    /**
     * Test grouping of ON condition (close group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::end_on_group
     */
    public function testClosingGroupOn()
    {
        $this->class->end_on_group();
        $this->assertPropertyEquals('join', ')');
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on
     */
    public function testOnWithDefaultOperator()
    {
        $this->class->on('left', 'right');
        $this->assertPropertyEquals('join', 'ON left = right');
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on
     */
    public function testOnWithCustomOperator()
    {
        $this->class->on('left', 'right', '>');
        $this->assertPropertyEquals('join', 'ON left > right');
    }

    /**
     * Test fluid interface of the on method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::on
     */
    public function testOnReturnsSelfReference()
    {
        $return = $this->class->on('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_like
     */
    public function testOnLike()
    {
        $this->class->on_like('left', 'right');
        $this->assertPropertyEquals('join', 'ON left LIKE right');
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_like
     */
    public function testOnNotLike()
    {
        $this->class->on_like('left', 'right', TRUE);
        $this->assertPropertyEquals('join', 'ON left NOT LIKE right');
    }

    /**
     * Test fluid interface of the on_like method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::on_like
     */
    public function testOnLikeReturnsSelfReference()
    {
        $return = $this->class->on_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_in
     */
    public function testOnIn()
    {
        $this->class->on_in('left', 'right');
        $this->assertPropertyEquals('join', 'ON left IN right');
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_in
     */
    public function testOnNotIn()
    {
        $this->class->on_in('left', 'right', TRUE);
        $this->assertPropertyEquals('join', 'ON left NOT IN right');
    }

    /**
     * Test fluid interface of the on_in method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::on_in
     */
    public function testOnInReturnsSelfReference()
    {
        $return = $this->class->on_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the on part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_between
     */
    public function testOnBetween()
    {
        $this->class->on_between('left', 'lower', 'upper');
        $this->assertPropertyEquals('join', 'ON left BETWEEN lower AND upper');
    }

    /**
     * Test specifying the on part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::on_between
     */
    public function testOnNotBetween()
    {
        $this->class->on_between('left', 'lower', 'upper', TRUE);
        $this->assertPropertyEquals('join', 'ON left NOT BETWEEN lower AND upper');
    }

    /**
     * Test fluid interface of the on_between method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::on_between
     */
    public function testOnBetweenReturnsSelfReference()
    {
        $return = $this->class->on_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test grouping of WHERE condition (start group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::start_where_group
     */
    public function testOpeningGroupWhere()
    {
        $this->class->start_where_group();
        $this->assertPropertyEquals('where', '(');
    }

    /**
     * Test grouping of WHERE condition (close group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::end_where_group
     */
    public function testClosingGroupWhere()
    {
        $this->class->end_where_group();
        $this->assertPropertyEquals('where', ')');
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where
     */
    public function testWhereWithDefaultOperator()
    {
        $this->class->where('left', 'right');
        $this->assertPropertyEquals('where', 'WHERE left = right');
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where
     */
    public function testWhereWithCustomOperator()
    {
        $this->class->where('left', 'right', '>');
        $this->assertPropertyEquals('where', 'WHERE left > right');
    }

    /**
     * Test fluid interface of the where method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::where
     */
    public function testWhereReturnsSelfReference()
    {
        $return = $this->class->where('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_like
     */
    public function testWhereLike()
    {
        $this->class->where_like('left', 'right');
        $this->assertPropertyEquals('where', 'WHERE left LIKE right');
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_like
     */
    public function testWhereNotLike()
    {
        $this->class->where_like('left', 'right', TRUE);
        $this->assertPropertyEquals('where', 'WHERE left NOT LIKE right');
    }

    /**
     * Test fluid interface of the where_like method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::where_like
     */
    public function testWhereLikeReturnsSelfReference()
    {
        $return = $this->class->where_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_in
     */
    public function testWhereIn()
    {
        $this->class->where_in('left', 'right');
        $this->assertPropertyEquals('where', 'WHERE left IN right');
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_in
     */
    public function testWhereNotIn()
    {
        $this->class->where_in('left', 'right', TRUE);
        $this->assertPropertyEquals('where', 'WHERE left NOT IN right');
    }

    /**
     * Test fluid interface of the where_in method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::where_in
     */
    public function testWhereInReturnsSelfReference()
    {
        $return = $this->class->where_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the where part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_between
     */
    public function testWhereBetween()
    {
        $this->class->where_between('left', 'lower', 'upper');
        $this->assertPropertyEquals('where', 'WHERE left BETWEEN lower AND upper');
    }

    /**
     * Test specifying the where part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::where_between
     */
    public function testWhereNotBetween()
    {
        $this->class->where_between('left', 'lower', 'upper', TRUE);
        $this->assertPropertyEquals('where', 'WHERE left NOT BETWEEN lower AND upper');
    }

    /**
     * Test fluid interface of the where_between method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::where_between
     */
    public function testWhereBetweenReturnsSelfReference()
    {
        $return = $this->class->where_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test grouping of HAVING condition (start group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::start_having_group
     */
    public function testOpeningGroupHaving()
    {
        $this->class->start_having_group();
        $this->assertPropertyEquals('having', '(');
    }

    /**
     * Test grouping of HAVING condition (close group).
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::end_having_group
     */
    public function testClosingGroupHaving()
    {
        $this->class->end_having_group();
        $this->assertPropertyEquals('having', ')');
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having
     */
    public function testHavingWithDefaultOperator()
    {
        $this->class->having('left', 'right');
        $this->assertPropertyEquals('having', 'HAVING left = right');
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having
     */
    public function testHavingWithCustomOperator()
    {
        $this->class->having('left', 'right', '>');
        $this->assertPropertyEquals('having', 'HAVING left > right');
    }

    /**
     * Test fluid interface of the having method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::having
     */
    public function testHavingReturnsSelfReference()
    {
        $return = $this->class->having('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_like
     */
    public function testHavingLike()
    {
        $this->class->having_like('left', 'right');
        $this->assertPropertyEquals('having', 'HAVING left LIKE right');
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_like
     */
    public function testHavingNotLike()
    {
        $this->class->having_like('left', 'right', TRUE);
        $this->assertPropertyEquals('having', 'HAVING left NOT LIKE right');
    }

    /**
     * Test fluid interface of the having_like method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::having_like
     */
    public function testHavingLikeReturnsSelfReference()
    {
        $return = $this->class->having_like('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_in
     */
    public function testHavingIn()
    {
        $this->class->having_in('left', 'right');
        $this->assertPropertyEquals('having', 'HAVING left IN right');
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_in
     */
    public function testHavingNotIn()
    {
        $this->class->having_in('left', 'right', TRUE);
        $this->assertPropertyEquals('having', 'HAVING left NOT IN right');
    }

    /**
     * Test fluid interface of the having_in method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::having_in
     */
    public function testHavingInReturnsSelfReference()
    {
        $return = $this->class->having_in('left', 'right');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the having part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionCreatesSimpleStatement
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_between
     */
    public function testHavingBetween()
    {
        $this->class->having_between('left', 'lower', 'upper');
        $this->assertPropertyEquals('having', 'HAVING left BETWEEN lower AND upper');
    }

    /**
     * Test specifying the having part of a query with non default operator.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsConditionTest::testConditionWithNonDefaultOperator
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::having_between
     */
    public function testHavingNotBetween()
    {
        $this->class->having_between('left', 'lower', 'upper', TRUE);
        $this->assertPropertyEquals('having', 'HAVING left NOT BETWEEN lower AND upper');
    }

    /**
     * Test fluid interface of the having_between method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::having_between
     */
    public function testHavingBetweenReturnsSelfReference()
    {
        $return = $this->class->having_between('left', 'lower', 'upper');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying a logical AND connector.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::sql_and
     */
    public function testSQLAnd()
    {
        $this->class->sql_and();
        $this->assertPropertyEquals('connector', 'AND');
    }

    /**
     * Test fluid interface of the sql_and method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::sql_and
     */
    public function testSQLAndReturnsSelfReference()
    {
        $return = $this->class->sql_and();

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying a logical OR connector.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::sql_or
     */
    public function testSQLOr()
    {
        $this->class->sql_or();
        $this->assertPropertyEquals('connector', 'OR');
    }

    /**
     * Test fluid interface of the sql_or method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::sql_or
     */
    public function testSQLOrReturnsSelfReference()
    {
        $return = $this->class->sql_or();

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}

?>
