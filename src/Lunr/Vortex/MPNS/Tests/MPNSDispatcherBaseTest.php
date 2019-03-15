<?php

/**
 * This file contains the MPNSDispatcherBaseTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSType;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the MPNSDispatcher class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSDispatcher
 */
class MPNSDispatcherBaseTest extends MPNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requests_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertSame($this->http, $this->get_reflection_property_value('http'));
    }

    /**
     * Test get_new_response_object_for_failed_request().
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::get_new_response_object_for_failed_request
     */
    public function testGetNewResponseObjectForFailedRequest(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_response_object_for_failed_request');

        $result = $method->invokeArgs($this->class, [ 'http://localhost/' ]);

        $this->assertInstanceOf('\Requests_Response', $result);
        $this->assertEquals('http://localhost/', $result->url);
    }

}

?>
