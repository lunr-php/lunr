<?php

/**
 * This file contains the MariaDMLQueryBuilderTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MariaDB\Tests;

use Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MariaDBDMLQueryBuilder class.
 *
 * @covers \Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder
 */
abstract class MariaDBDMLQueryBuilderTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class      = new MariaDBDMLQueryBuilder();
        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MariaDB\MariaDBDMLQueryBuilder');
    }

}

?>
