<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsInsertTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building INSERT and REPLACE statements
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsUpdateTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the SET part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateEmptyByDefault
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_update
     */
    public function testInitialUpdate()
    {
        $method = $this->builder_reflection->getMethod('sql_update');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('update');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table1'));

        $string = 'table1';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the SET part of a query incrementally.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateEmptyByDefault
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_update
     */
    public function testIncrementalUpdate()
    {
        $method = $this->builder_reflection->getMethod('sql_update');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('update');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table1'));
        $method->invokeArgs($this->builder, array('table2'));

        $string = 'table1, table2';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

}
?>
