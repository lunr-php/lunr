<?php

/**
 * This file contains the CentralAuthenticationStoreTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Spark\CentralAuthenticationStore;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CentralAuthenticationStore class.
 *
 * @covers Lunr\Spark\CentralAuthenticationStore
 */
abstract class CentralAuthenticationStoreTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var CentralAuthenticationStore
     */
    protected CentralAuthenticationStore $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new CentralAuthenticationStore();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);

        parent::tearDown();
    }

}

?>
