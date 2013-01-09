<?php

/**
 * This file contains the DatabaseDMLQueryBuilderEscapeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for escaping and preparing query fields.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderEscapeTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test escaping column names.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::escape_location_reference
     */
    public function testEscapeLocationReference($col, $escaped)
    {
        $method = $this->builder_reflection->getMethod('escape_location_reference');
        $method->setAccessible(TRUE);

        $this->assertEquals($escaped, $method->invokeArgs($this->builder, array($col)));
    }

}

?>
