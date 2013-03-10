<?php

/**
 * This file contains the DatabaseDMLQueryBuilderEscapeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for escaping and preparing query fields.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
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
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::escape_location_reference
     */
    public function testEscapeLocationReference($col, $escaped)
    {
        $method = $this->builder_reflection->getMethod('escape_location_reference');
        $method->setAccessible(TRUE);

        $this->assertEquals($escaped, $method->invokeArgs($this->builder, array($col)));
    }

}

?>
