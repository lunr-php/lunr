<?php

/**
 * This file contains the MariaDBSimpleDMLQueryBuilderBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use ReflectionClass;
use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;
use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use Lunr\Gravity\Database\MariaDB\Tests\MariaDBSimpleDMLQueryBuilderTest;

/**
 * This class contains basic tests for the MariaDBSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MariaDB\MariaDBSimpleDMLQueryBuilder
 */
class MariaDBSimpleDMLQueryBuilderBaseTest extends MariaDBSimpleDMLQueryBuilderTest
{

    /**
     * Test the builder class is passed correctly.
     */
    public function testBuilderIsPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder';
        $this->assertInstanceOf($instance, $this->builder);
    }

    /**
     * Test the QueryEscaper class is passed correctly.
     */
    public function testEscaperIsPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MySQL\MySQLQueryEscaper';
        $this->assertInstanceOf($instance, $this->escaper);
    }

}

?>
