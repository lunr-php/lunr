<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

/**
 * This class contains tests for the push() method of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
class APNSDispatcherPushTest extends APNSDispatcherTest
{

    /**
     * Test that push() returns APNSResponseObject.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushReturnsAPNSResponseObject()
    {
        $endpoints = [];

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushResetsProperties()
    {
        if (defined('REFLECTION_BUG_72194') && REFLECTION_BUG_72194 === TRUE)
        {
            $this->markTestSkipped('Reflection can\'t handle this right now');
            return;
        }

        $endpoints = [];

        $this->class->push($this->payload, $endpoints);

        $this->assertPropertySame('apns_message', NULL);
    }

    /**
     * Test that push() with a non JSON payload proceeds correctly without error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushWithNonJSONPayloadProceedsWithoutError()
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"yo"}');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() constructs the correct full payload.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushConstructsCorrectPayload()
    {
        $endpoints = [];

        $payload = '{"alert":"message","sound":"yo.mp3","yo":"he","badge":7,"custom_data":{"key1":"value1","key2":"value2"}}';

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->apns_message->expects($this->once())
                           ->method('setText')
                           ->with('message');

        $this->apns_message->expects($this->once())
                           ->method('setSound')
                           ->with('yo.mp3');

        $this->apns_message->expects($this->once())
                           ->method('setBadge')
                           ->with(7);

        $this->apns_message->expects($this->exactly(2))
                           ->method('setCustomProperty')
                           ->withConsecutive(
                               [ 'key1', 'value1' ],
                               [ 'key2', 'value2' ]
                           );

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() log payload building error with badge.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogPayloadBuildingBadgeError()
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"badge":"yo"}');

        $this->apns_message->expects($this->once())
                           ->method('setBadge')
                           ->with('yo')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid badge: yo')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid badge: yo');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log payload building error with custom property.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogPayloadBuildingCustomPropertyError()
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"custom_data":{"apns":"value1"}}');

        $this->apns_message->expects($this->once())
                           ->method('setCustomProperty')
                           ->with('apns', 'value1')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Reserved keyword: apns')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Reserved keyword: apns');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() add all endpoints to the message.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushAddAllEndpointsToMessage()
    {
        $endpoints = [ 'endpoint1', 'endpoint2' ];

        $this->apns_message->expects($this->exactly(2))
                           ->method('addRecipient')
                           ->withConsecutive([ 'endpoint1' ], [ 'endpoint2' ]);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() log invalid endpoints.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogInvalidEndpoints()
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3' ];

        $pos = 0;

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint1')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid endpoint: endpoint1')));

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint2');

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint3')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid endpoint: endpoint3')));

        $this->logger->expects($this->exactly(2))
                     ->method('warning')
                     ->withConsecutive(
                        [ 'Invalid endpoint: endpoint1' ],
                        [ 'Invalid endpoint: endpoint3' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log failed connection.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogFailedConnection()
    {
        $endpoints = [];

        $this->apns_push->expects($this->once())
                        ->method('connect')
                        ->will($this->throwException(new \ApnsPHP_Exception('Failed to connect')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Failed to connect' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log failed sending.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogFailedSending()
    {
        $endpoints = [];

        $this->apns_push->expects($this->once())
                        ->method('send')
                        ->will($this->throwException(new \ApnsPHP_Push_Exception('Failed to send')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Failed to send' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() send successfully.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushSuccess()
    {
        $endpoints = [];

        $pos = 0;

        $this->apns_push->expects($this->at($pos++))
                        ->method('add')
                        ->with($this->apns_message);

        $this->apns_push->expects($this->at($pos++))
                        ->method('connect');

        $this->apns_push->expects($this->at($pos++))
                        ->method('send');

        $this->apns_push->expects($this->at($pos++))
                        ->method('disconnect');

        $error = [
            [
                'MESSAGE' => 'Error',
                'ERRORS'  => [],
            ],
        ];

        $this->apns_push->expects($this->at($pos++))
                        ->method('getErrors')
                        ->willReturn($error);

        $this->logger->expects($this->never())
                     ->method('warning');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

}

?>
