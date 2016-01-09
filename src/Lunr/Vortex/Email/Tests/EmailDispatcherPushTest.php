<?php

/**
 * This file contains the EmailDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains test for the push() method of the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
class EmailDispatcherPushTest extends EmailDispatcherTest
{

    /**
     * Test that push() returns EmailResponseObject.
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::push
     */
    public function testPushReturnsEmailResponseObject()
    {
        $this->set_reflection_property_value('endpoint', 'recipient@domain.com');
        $this->set_reflection_property_value('source', 'sender@domain.com');
        $this->set_reflection_property_value('payload', '{"subject": "subject", "body": "body"}');

        $this->mail->expects($this->once())
                   ->method('set_from')
                   ->with($this->get_reflection_property_value('source'));

        $this->mail->expects($this->once())
                   ->method('add_to')
                   ->with($this->get_reflection_property_value('endpoint'));

        $this->mail->expects($this->once())
                   ->method('set_subject')
                   ->with('subject');

        $this->mail->expects($this->once())
                   ->method('set_message')
                   ->with('body');

        $this->mail->expects($this->once())
                   ->method('send')
                   ->will($this->returnValue(TRUE));

        $this->assertInstanceOf('Lunr\Vortex\Email\EmailResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'recipient@domain.com');
        $this->set_reflection_property_value('source', 'sender@domain.com');
        $this->set_reflection_property_value('payload', '{"subject": "subject", "body": "body"}');

        $this->mail->expects($this->once())
                   ->method('send')
                   ->will($this->returnValue(TRUE));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
    }

}

?>
