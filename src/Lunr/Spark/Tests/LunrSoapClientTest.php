<?php

/**
 * This file contains the LunrSoapClientTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Tests;

use Lunr\Spark\LunrSoapClient;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the LunrSoapClient class.
 *
 * @covers Lunr\Spark\LunrSoapClient
 */
abstract class LunrSoapClientTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class      = new LunrSoapClient();
        $this->reflection = new ReflectionClass('Lunr\Spark\LunrSoapClient');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

}

?>
