<?php

/**
 * This file contains the GCMDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMType;

/**
 * This class contains test for the constructor of the GCMDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherBaseTest extends GCMDispatcherTest
{

    /**
     * Test that the endpoint is set to an empty array by default.
     */
    public function testEndpointIsEmptyArray()
    {
        $this->assertPropertyEquals('endpoint', '');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEquals('payload', '');
    }

    /**
     * Test that the passed Curl object is set correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertSame($this->curl, $this->get_reflection_property_value('curl'));
    }

    /**
     * Test that the passed Logger object is set correctly.
     */
    public function testLoggerIsSetCorrectly()
    {
        $this->assertSame($this->logger, $this->get_reflection_property_value('logger'));
    }

    /**
     * Test that the auth token is set to an empty string by default.
     */
    public function testAuthTokenIsEmptyString()
    {
        $this->assertPropertyEquals('auth_token', '');
    }

}

?>
