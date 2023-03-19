<?php

/**
 * This file contains the ViewBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Base tests for the view class.
 *
 * @covers     Lunr\Corona\View
 */
class ViewBaseTest extends ViewTest
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly(): void
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the request ID header is set.
     *
     * @requires extension xdebug
     * @runInSeparateProcess
     */
    public function testRequestIdHeaderIsSet(): void
    {
        $headers = xdebug_get_headers();

        $this->assertIsArray($headers);
        $this->assertNotEmpty($headers);

        $value = strpos($headers[0], 'X-Xdebug-Profile-Filename') !== FALSE ? $headers[1] : $headers[0];

        $this->assertEquals('X-Request-ID: 962161b27a0141f384c63834ad001adf', $value);
    }

}

?>
