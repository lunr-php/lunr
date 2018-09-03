<?php

/**
 * This file contains the ViewBaseTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
    public function testRequestSetCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the request ID header is set.
     *
     * @runInSeparateProcess
     */
    public function testRequestIdHeaderIsSet()
    {
        $headers = xdebug_get_headers();

        $this->assertInternalType('array', $headers);
        $this->assertNotEmpty($headers);

        $value = strpos($headers[0], 'X-Xdebug-Profile-Filename') !== FALSE ? $headers[1] : $headers[0];

        $this->assertEquals('X-Request-ID: 962161b27a0141f384c63834ad001adf', $value);
    }

}

?>
