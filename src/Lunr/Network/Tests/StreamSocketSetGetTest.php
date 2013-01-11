<?php

/**
 * This file contains the StreamSocketSetGetTest class.
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
 * This class contains test methods for the getters and setters of the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketSetGetTest extends StreamSocketTest
{

    /**
     * Tests that the value of valid properties can be retrieved correctly.
     *
     * @param String $property Property name
     * @param mixed  $value    Property value
     *
     * @dataProvider validPropertyProvider
     * @covers       Lunr\Network\StreamSocket::__get
     */
    public function testGetReturnsValuesForValidProperties($property, $value)
    {
        $this->assertEquals($value, $this->stream_socket->$property);
    }

    /**
     * Tests that the value of invalid properties is retrieved as NULL.
     *
     * @covers Lunr\Network\StreamSocket::__get
     */
    public function testGetReturnsNullForInvalidProperties()
    {
        $this->assertNull($this->stream_socket->invalid_property);
    }

    /**
     * Tests that set_context_option() sets properly the option and its value in the correct wrapper.
     *
     * @param String $wrapper The wrapper to set the option in
     * @param String $option  The option to set within the wrapper
     * @param mixed  $value   The value of the set option
     *
     * @dataProvider validWrapperProvider
     * @covers       Lunr\Network\StreamSocket::set_context_option
     */
    public function testSetContextOptionWithValidWrapper($wrapper, $option, $value)
    {
        $property = $this->stream_socket_reflection->getProperty('context_options');
        $property->setAccessible(TRUE);

        $this->stream_socket->set_context_option($wrapper, $option, $value);

        $context = $property->getValue($this->stream_socket);

        $this->assertArrayHasKey($wrapper, $context);

        $this->assertArrayHasKey($option, $context[$wrapper]);
        $this->assertEquals($value, $context[$wrapper][$option]);
    }

    /**
     * Tests that the context_options property is not modified with illegal or invalid wrapper.
     *
     * @param String $wrapper The wrapper to set the option in
     * @param String $option  The option to set within the wrapper
     * @param mixed  $value   The value of the set option
     *
     * @dataProvider invalidWrapperProvider
     * @depends      Lunr\Network\Tests\StreamSocketSetGetTest::testSetContextOptionWithValidWrapper
     * @covers       Lunr\Network\StreamSocket::set_context_option
     */
    public function testSetContextOptionWithInvalidWrapper($wrapper, $option, $value)
    {
        $property = $this->stream_socket_reflection->getProperty('context_options');
        $property->setAccessible(TRUE);

        $previous = $property->getValue($this->stream_socket);

        $this->stream_socket->set_context_option($wrapper, $option, $value);

        $this->assertEquals($previous, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that set_context_options() sets properly the given array.
     *
     * @depends Lunr\Network\Tests\StreamSocketSetGetTest::testSetContextOptionWithValidWrapper
     * @covers  Lunr\Network\StreamSocket::set_context_options
     */
    public function testSetContextOptionsWithValidInput()
    {
        $options = array(
            'http' => array('method' => 'POST'),
            'ftp'  => array('overwrite' => FALSE),
            'tcp'  => array('bindto' => '127.0.0.1:4321'),
        );

        $property = $this->stream_socket_reflection->getProperty('context_options');
        $property->setAccessible(TRUE);

        $this->stream_socket->set_context_options($options);

        $context = $property->getValue($this->stream_socket);

        foreach($options as $wrapper_key => $wrapper)
        {
            $this->assertArrayHasKey($wrapper_key, $context);

            foreach($wrapper as $option => $value)
            {
                $this->assertArrayHasKey($option, $wrapper);
                $this->assertEquals($value, $wrapper[$option]);
            }
        }
    }

    /**
     * Tests that set_options() does not do anything if input is not an array.
     *
     * @param mixed $value The non-array invalid input
     *
     * @dataProvider invalidOptionsProvider
     * @covers       Lunr\Network\StreamSocket::set_context_options
     */
    public function testSetContextOptionsIfInputIsNotArray($value)
    {
        $property = $this->stream_socket_reflection->getProperty('context_options');
        $property->setAccessible(TRUE);

        $previous = $property->getValue($this->stream_socket);

        $this->stream_socket->set_context_options($value);

        $this->assertEquals($previous, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that the blocking property is properly set with valid values.
     *
     * @param Boolean $value A valid value for blocking property
     *
     * @dataProvider validBlockingProvider
     * @covers       Lunr\Network\StreamSocket::set_blocking
     */
    public function testSetBlockingWithValidInput($value)
    {
        $property = $this->stream_socket_reflection->getProperty('blocking');
        $property->setAccessible(TRUE);

        $this->stream_socket->set_blocking($value);

        $this->assertEquals($value, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that blocking property is not modified if invalid input provided.
     *
     * @param mixed $value A invalid value for blocking property
     *
     * @dataProvider invalidBlockingProvider
     * @covers       Lunr\Network\StreamSocket::set_blocking
     */
    public function testSetBlockingWithInvalidInput($value)
    {
        $property = $this->stream_socket_reflection->getProperty('blocking');
        $property->setAccessible(TRUE);

        $previous = $property->getValue($this->stream_socket);

        $this->stream_socket->set_blocking($value);

        $this->assertEquals($previous, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that notification property is properly set.
     *
     * @covers Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallBack()
    {
        $value = array($this, 'notification');

        $property = $this->stream_socket_reflection->getProperty('notification');
        $property->setAccessible(TRUE);

        $this->stream_socket->set_notification_callback($value);

        $this->assertEquals($value, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that notification property is properly set.
     *
     * @param mixed $value the invalid notification callback to test
     *
     * @dataProvider invalidNotificationCallBackProvider
     * @covers Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallBackWithInvalidValue($value)
    {
        $property = $this->stream_socket_reflection->getProperty('notification');
        $property->setAccessible(TRUE);

        $this->stream_socket->set_notification_callback($value);

        $this->assertFalse($value === $property->getValue($this->stream_socket));
    }

    /**
     * Tests that timeout_seconds is properly set with valid value.
     *
     * @param Integer $seconds The timeout part in seconds to test
     * @param Integer $micros  The timeout part in microseconds to test
     *
     * @dataProvider validTimeoutProvider
     * @covers       Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutWithValidValue($seconds, $micros)
    {
        $timeout_seconds = $this->stream_socket_reflection->getProperty('timeout_seconds');
        $timeout_seconds->setAccessible(TRUE);

        $timeout_microseconds = $this->stream_socket_reflection->getProperty('timeout_microseconds');
        $timeout_microseconds->setAccessible(TRUE);

        $this->stream_socket->set_timeout($seconds, $micros);

        $this->assertEquals($seconds, $timeout_seconds->getValue($this->stream_socket));
        $this->assertEquals($micros, $timeout_microseconds->getValue($this->stream_socket));
    }

    /**
     * Tests that timeout_seconds is not set with invalid value.
     *
     * @param Integer $seconds The timeout part in seconds to test
     * @param Integer $micros  The timeout part in microseconds to test
     *
     * @dataProvider invalidTimeoutProvider
     * @covers       Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutWithInvalidValue($seconds, $micros)
    {
        $timeout_seconds = $this->stream_socket_reflection->getProperty('timeout_seconds');
        $timeout_seconds->setAccessible(TRUE);

        $timeout_microseconds = $this->stream_socket_reflection->getProperty('timeout_microseconds');
        $timeout_microseconds->setAccessible(TRUE);

        $this->stream_socket->set_timeout($seconds, $micros);

        $this->assertFalse($seconds === $timeout_seconds->getValue($this->stream_socket));
        $this->assertFalse($micros === $timeout_microseconds->getValue($this->stream_socket));
    }

    /**
     * Tests that the set timeout method with default microseconds parameter.
     *
     * @covers Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutWithDefaultMicroseconds()
    {
        $timeout_seconds = $this->stream_socket_reflection->getProperty('timeout_seconds');
        $timeout_seconds->setAccessible(TRUE);

        $timeout_microseconds = $this->stream_socket_reflection->getProperty('timeout_microseconds');
        $timeout_microseconds->setAccessible(TRUE);

        $value = $timeout_microseconds->getValue($this->stream_socket);

        $this->stream_socket->set_timeout(1);

        $this->assertTrue(1 === $timeout_seconds->getValue($this->stream_socket));
        $this->assertTrue(0 === $timeout_microseconds->getValue($this->stream_socket));
        $this->assertSame($value, $timeout_microseconds->getValue($this->stream_socket));
    }

    /**
     * Test the fluid interface of the set_context_option() method.
     *
     * @covers Lunr\Network\StreamSocket::set_context_option
     */
    public function testSetContextOptionReturnsSelfReference()
    {
        $return = $this->stream_socket->set_context_option('http', 'method', 'POST');

        $this->assertEquals($return, $this->stream_socket);
    }

    /**
     * Test the fluid interface of the set_context_options() method.
     *
     * @covers Lunr\Network\StreamSocket::set_context_options
     */
    public function testSetContextOptionsReturnsSelfReference()
    {
        $value = array('http' => array('method' => 'POST'));

        $return = $this->stream_socket->set_context_options($value);

        $this->assertEquals($return, $this->stream_socket);
    }

    /**
     * Test the fluid interface of the set_blocking() method.
     *
     * @covers Lunr\Network\StreamSocket::set_blocking
     */
    public function testSetBlockingReturnsSelfReference()
    {
        $return = $this->stream_socket->set_blocking(0);

        $this->assertEquals($return, $this->stream_socket);
    }

    /**
     * Test the fluid interface of the set_notification_callback() method.
     *
     * @covers Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallbackReturnsSelfReference()
    {
        $return = $this->stream_socket->set_notification_callback('notification');

        $this->assertEquals($return, $this->stream_socket);
    }

    /**
     * Test the fluid interface of the set_timeout() method.
     *
     * @covers Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutReturnsSelfReference()
    {
        $return = $this->stream_socket->set_timeout(1);

        $this->assertEquals($return, $this->stream_socket);
    }

}

?>
