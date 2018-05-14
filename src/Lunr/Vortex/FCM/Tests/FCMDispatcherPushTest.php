<?php

/**
 * This file contains the FCMDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains test for the push() method of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherPushTest extends FCMDispatcherTest
{

    /**
     * Test that push() returns FCMResponseObject.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushReturnsFCMResponseObject()
    {
        $endpoints = [];

        $this->constant_redefine('Lunr\Vortex\FCM\FCMDispatcher::BATCH_SIZE', 2);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $result);
    }

    /**
     * Test that push_batch() returns FCMBatchResponse.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push_batch
     */
    public function testPushBatchReturnsFCMBatchResponseObject()
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->will($this->returnValue($response));

        $method = $this->get_accessible_reflection_method('push_batch');
        $result = $method->invokeArgs($this->class, [ $this->payload, &$endpoints ]);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMBatchResponse', $result);
    }

}

?>
