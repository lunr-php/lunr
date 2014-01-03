<?php

/**
 * This file contains the StreamSocketExecuteTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

/**
 * This class contains test methods for stream context of the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketContextTest extends StreamSocketTest
{

    /**
     * Tests that create_context() methods sets the stream context options.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextSetsContextOptionsIfContextOptionsNotEmpty()
    {
        $value = ['http' => ['method' => ' POST']];

        $this->class->set_context_options($value);

        $method = $this->get_accessible_reflection_method('create_context');

        $method->invoke($this->class);

        $options = stream_context_get_options($this->get_reflection_property_value('context'));

        $this->assertArrayHasKey('http', $options);
        $this->assertEquals($value['http'], $options['http']);
    }

    /**
     * Tests that create_context() methods sets nothing if no context options set.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextDoesNotSetContextOptionsIfContextOptionsEmpty()
    {
        $method = $this->get_accessible_reflection_method('create_context');

        $method->invoke($this->class);

        $this->assertEmpty(stream_context_get_options($this->get_reflection_property_value('context')));
    }

    /**
     * Tests that create_context() methods sets the notification callback method.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextSetsNotificationCallbackIfNotificationNotEmpty()
    {
        $notification = [$this, 'notification'];

        $this->class->set_notification_callback($notification);

        $method = $this->get_accessible_reflection_method('create_context');

        $method->invoke($this->class);

        $params = stream_context_get_params($this->get_reflection_property_value('context'));

        $this->assertArrayHasKey('notification', $params);
        $this->assertEquals($notification, $params['notification']);
    }

    /**
     * Tests that create_context() does not set notification callback method if notification is empty.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextDoesNotSetNotificationCallbackIfNotificationIsNull()
    {
        $method = $this->get_accessible_reflection_method('create_context');

        $method->invoke($this->class);

        $params = stream_context_get_params($this->get_reflection_property_value('context'));

        $this->assertArrayNotHasKey('notification', $params);
    }

    /**
     * Tests that the context is created with null notification callback.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextIsCreatedWithNullNotification()
    {
        $method = $this->get_accessible_reflection_method('create_context');

        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('context');

        $this->assertNotNull($value);
        $this->assertTrue(is_resource($value));
    }

    /**
     * Tests that create_context() method returns a context resource.
     *
     * @covers Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextReturnsResource()
    {
        $method = $this->get_accessible_reflection_method('create_context');

        $return = $method->invoke($this->class);

        $this->assertTrue(is_resource($return));
        $this->assertEquals('stream-context', get_resource_type($return));
    }

}

?>
