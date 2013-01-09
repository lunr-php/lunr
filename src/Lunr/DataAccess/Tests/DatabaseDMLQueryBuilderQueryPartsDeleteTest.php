<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsDeleteTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building DELETE statements
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsDeleteTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the delete part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testDeleteEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testInitialDelete()
    {
        $method = $this->builder_reflection->getMethod('sql_delete');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('delete');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));

        $string = 'table';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

    /**
     * Test specifying the select part of a query.
     *
     * @depends Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderBaseTest::testDeleteEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testIncrementalDelete()
    {
        $method = $this->builder_reflection->getMethod('sql_delete');
        $method->setAccessible(TRUE);

        $property = $this->builder_reflection->getProperty('delete');
        $property->setAccessible(TRUE);

        $method->invokeArgs($this->builder, array('table'));
        $method->invokeArgs($this->builder, array('table.*'));

        $string = 'table, table.*';

        $this->assertEquals($string, $property->getValue($this->builder));
    }

}

?>
