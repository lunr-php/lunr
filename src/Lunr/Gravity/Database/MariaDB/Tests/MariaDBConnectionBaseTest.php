<?php

/**
 * This file contains the MariaDBConnectionBaseTest class.
 *
 * PHP Version 7.0
 *
 * @package    Lunr\Gravity\Database\MariaDB
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\Tests\MariaDBConnectionTest;

/**
 * This class contains basic tests for the MariaDBConnection class
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBConnection
 */
class MariaDBConnectionBaseTest extends MariaDBConnectionTest
{

    /**
     * Test getting a new DMLQueryBuilder.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBConnection::get_new_dml_query_builder_object
     */
    public function testGetDMLQueryBuilder()
    {
        $querybuilder = $this->class->get_new_dml_query_builder_object(FALSE);

        $instance = 'Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder';
        $this->assertInstanceOf($instance, $querybuilder);
    }

    /**
     * Test getting a new DMLQueryBuilder.
     *
     * @covers Lunr\Gravity\Database\MariaDB\MariaDBConnection::get_new_dml_query_builder_object
     */
    public function testGetSimpleDMLQueryBuilder()
    {
        $querybuilder = $this->class->get_new_dml_query_builder_object(TRUE);

        $instance = 'Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder';
        $this->assertInstanceOf($instance, $querybuilder);
    }

}

?>
