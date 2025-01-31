<?php

/**
 * This file contains the LunrSoapClientBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Tests;

/**
 * This class contains basic tests for the LunrSoapClient class.
 *
 * @covers Lunr\Spark\LunrSoapClient
 */
class LunrSoapClientInitTest extends LunrSoapClientTestCase
{

    /**
     * Test that __construct constructs empty client.
     *
     * @covers Lunr\Spark\LunrSoapClient::__construct
     */
    public function testConstructConstructsEmptyClient(): void
    {
        $functions = $this->class->__getFunctions();
        $this->assertEmpty($functions);
    }

    /**
     * Test that init constructs the client.
     *
     * @covers Lunr\Spark\LunrSoapClient::init
     */
    public function testInitConstructsClient(): void
    {
        $wsdl = TEST_STATICS . '/Spark/hello.wsdl';

        $this->class->init($wsdl, []);

        $functions = $this->class->__getFunctions();
        $this->assertContains('string sayHello(string $firstName)', $functions);
    }

    /**
     * Test init returns a self reference.
     *
     * @covers Lunr\Spark\LunrSoapClient::init
     */
    public function testInitReturnsSelfReference(): void
    {
        $wsdl = TEST_STATICS . '/Spark/hello.wsdl';

        $value = $this->class->init($wsdl, []);

        $this->assertInstanceOf('Lunr\Spark\LunrSoapClient', $value);
        $this->assertSame($this->class, $value);
    }

}

?>
