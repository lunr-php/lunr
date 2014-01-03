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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::on_regexp
     */
    public function testOnRegexp()
    {
        $this->class->on_regexp('left', 'right');
        $this->assertPropertyEquals('join', 'ON left REGEXP right');
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
        $this->assertPropertyEquals('join', 'ON left NOT REGEXP right');
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::where_regexp
     */
    public function testWhereRegexp()
    {
        $this->class->where_regexp('left', 'right');
        $this->assertPropertyEquals('where', 'WHERE left REGEXP right');
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
        $this->assertPropertyEquals('where', 'WHERE left NOT REGEXP right');
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::having_regexp
     */
    public function testHavingRegexp()
    {
        $this->class->having_regexp('left', 'right');
        $this->assertPropertyEquals('having', 'HAVING left REGEXP right');
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
        $this->assertPropertyEquals('having', 'HAVING left NOT REGEXP right');
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

}

?>
