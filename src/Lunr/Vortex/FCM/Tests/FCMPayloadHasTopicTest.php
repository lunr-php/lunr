<?php

/**
 * This file contains the FCMPayloadHasTopicTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Koen Woortman <k.woortman@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the has_topic method of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadHasTopicTest extends FCMPayloadTest
{

    /**
     * Test has_topic() returns FALSE when a topic is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_topic
     */
    public function testWhenNoTopicIsSet()
    {
        $this->assertFalse($this->class->has_topic());
    }

    /**
     * Test if has_topic() returns TRUE when a topic is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_topic
     */
    public function testWhenTopicIsSetCorrectly()
    {
        $this->class->set_topic('news');

        $this->assertTrue($this->class->has_topic());
    }

}

?>
