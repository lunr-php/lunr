<?php

/**
 * This file contains the StreamSocketExecuteTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for stream context of the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketContextTest extends StreamSocketTest
{

    /**
     * Tests that create_context() methods sets the stream context options.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextSetsContextOptionsIfContextOptionsNotEmpty()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $value = array( 'http' => array('method' => ' POST'));

        $this->stream_socket->set_context_options($value);

        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket);

        $options = stream_context_get_options($property->getValue($this->stream_socket));

        $this->assertArrayHasKey('http', $options);
        $this->assertEquals($value['http'], $options['http']);
    }

    /**
     * Tests that create_context() methods sets nothing if no context options set.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextDoesNotSetContextOptionsIfContextOptionsEmpty()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket);

        $this->assertEmpty(stream_context_get_options($property->getValue($this->stream_socket)));
    }

    /**
     * Tests that create_context() methods sets the notification callback method.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextSetsNotificationCallbackIfNotificationNotEmpty()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $notification = array($this, 'notification');

        $this->stream_socket->set_notification_callback($notification);

        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket);

        $params = stream_context_get_params($property->getValue($this->stream_socket));

        $this->assertArrayHasKey('notification', $params);
        $this->assertEquals($notification, $params['notification']);
    }

    /**
     * Tests that create_context() does not set notification callback method if notification is empty.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextDoesNotSetNotificationCallbackIfNotificationIsNull()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket);

        $params = stream_context_get_params($property->getValue($this->stream_socket));

        $this->assertArrayNotHasKey('notification', $params);
    }

    /**
     * Tests that the context is created with null notification callback.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextIsCreatedWithNullNotification()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket);

        $this->assertNotNull($property->getValue($this->stream_socket));
        $this->assertTrue(is_resource($property->getValue($this->stream_socket)));
    }

    /**
     * Tests that create_context() method returns a context resource.
     *
     * @covers  Lunr\Network\StreamSocket::create_context
     */
    public function testCreateContextReturnsResource()
    {
        $method = $this->stream_socket_reflection->getMethod('create_context');
        $method->setAccessible(TRUE);

        $return = $method->invoke($this->stream_socket);

        $this->assertTrue(is_resource($return));
        $this->assertEquals('stream-context', get_resource_type($return));
    }

}

?>
