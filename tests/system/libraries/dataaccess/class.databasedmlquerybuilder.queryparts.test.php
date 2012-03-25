<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts methods.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the select part of a query, no escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectNoEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));

        $string = 'col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectNoEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, TRUE));

        $string = 'HEX(col) AS col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAlias
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', TRUE, FALSE));

        $string = '`col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAliasHex
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', TRUE, TRUE));

        $string = 'HEX(`col`) AS `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectNoEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));

        $string = 'col, col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, no escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectNoEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', FALSE, TRUE));

        $string = 'col, HEX(col) AS col';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, no hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAlias
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectEscapeNoHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', TRUE, FALSE));

        $string = 'col, `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query, escaping, hex.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testSelectEmptyByDefault
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeAliasOneColumnNoAliasHex
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectEscapeHex()
    {
        $method = $this->builder_reflection->getMethod('sql_select');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('col', FALSE, FALSE));
        $method->invokeArgs($this->builder, array('col', TRUE, TRUE));

        $string = 'col, HEX(`col`) AS `col`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the from part of a query.
     *
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_from
     */
    public function testFrom()
    {
        $method = $this->builder_reflection->getMethod('sql_from');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));

        $string = 'FROM `table`';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

}

?>
