<?php

/**
 * This file contains the FCMPayloadHasConditionTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Koen Woortman <k.woortman@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the has_condition method of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadHasConditionTest extends FCMPayloadTest
{

    /**
     * Test has_condition() returns FALSE when no condition is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_condition
     */
    public function testWhenNoConditionIsSet()
    {
        $this->assertFalse($this->class->has_condition());
    }

    /**
     * Test if has_condition() returns TRUE when condition is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_condition
     */
    public function testWhenConditionIsSetCorrectly()
    {
        $this->class->set_condition("'TopicA' in topics && 'TopicB' in topics");

        $this->assertTrue($this->class->has_condition());
    }

}

?>
