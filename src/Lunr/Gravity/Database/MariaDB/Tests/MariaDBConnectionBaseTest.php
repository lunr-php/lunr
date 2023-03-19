<?php

/**
 * This file contains the MariaDBConnectionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testGetDMLQueryBuilder(): void
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
    public function testGetSimpleDMLQueryBuilder(): void
    {
        $querybuilder = $this->class->get_new_dml_query_builder_object(TRUE);

        $instance = 'Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder';
        $this->assertInstanceOf($instance, $querybuilder);
    }

}

?>
