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
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the query parts methods that are used when building DELETE statements
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsDeleteTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the delete part of a query.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testDeleteEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_delete
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
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderBaseTest::testDeleteEmptyByDefault
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::sql_delete
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
