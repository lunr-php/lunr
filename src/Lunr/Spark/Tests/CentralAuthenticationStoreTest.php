<?php

/**
 * This file contains the CentralAuthenticationStoreTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Tests;

use Lunr\Spark\CentralAuthenticationStore;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CentralAuthenticationStore class.
 *
 * @covers Lunr\Spark\CentralAuthenticationStore
 */
abstract class CentralAuthenticationStoreTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class      = new CentralAuthenticationStore();
        $this->reflection = new ReflectionClass('Lunr\Spark\CentralAuthenticationStore');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
