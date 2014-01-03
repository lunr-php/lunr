<?php

/**
 * This file contains the StreamSocketSetGetTest class.
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
 * This class contains test methods for the getters and setters of the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
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
        $this->assertEquals($value, $this->class->$property);
    }

    /**
     * Tests that the value of invalid properties is retrieved as NULL.
     *
     * @covers Lunr\Network\StreamSocket::__get
     */
    public function testGetReturnsNullForInvalidProperties()
    {
        $this->assertNull($this->class->invalid_property);
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
        $this->class->set_context_option($wrapper, $option, $value);

        $context = $this->get_reflection_property_value('context_options');

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
        $previous = $this->get_reflection_property_value('context_options');

        $this->class->set_context_option($wrapper, $option, $value);

        $this->assertPropertyEquals('context_options', $previous);
    }

    /**
     * Tests that set_context_options() sets properly the given array.
     *
     * @depends Lunr\Network\Tests\StreamSocketSetGetTest::testSetContextOptionWithValidWrapper
     * @covers  Lunr\Network\StreamSocket::set_context_options
     */
    public function testSetContextOptionsWithValidInput()
    {
        $options = [
            'http' => ['method' => 'POST'],
            'ftp' => ['overwrite' => FALSE],
            'tcp' => ['bindto' => '127.0.0.1:4321']
        ];

        $this->class->set_context_options($options);

        $context = $this->get_reflection_property_value('context_options');

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
        $previous = $this->get_reflection_property_value('context_options');

        $this->class->set_context_options($value);

        $this->assertPropertyEquals('context_options', $previous);
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
        $this->class->set_blocking($value);

        $this->assertPropertyEquals('blocking', $value);
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
        $previous = $this->get_reflection_property_value('blocking');

        $this->class->set_blocking($value);

        $this->assertPropertyEquals('blocking', $previous);
    }

    /**
     * Tests that notification property is properly set.
     *
     * @covers Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallBack()
    {
        $value = array($this, 'notification');

        $property = $this->reflection->getProperty('notification');
        $property->setAccessible(TRUE);

        $this->class->set_notification_callback($value);

        $this->assertEquals($value, $property->getValue($this->class));
    }

    /**
     * Tests that notification property is properly set.
     *
     * @param mixed $value the invalid notification callback to test
     *
     * @dataProvider invalidNotificationCallBackProvider
     * @covers       Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallBackWithInvalidValue($value)
    {
        $this->class->set_notification_callback($value);

        $this->assertFalse($value === $this->get_reflection_property_value('notification'));
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
        $this->class->set_timeout($seconds, $micros);

        $this->assertPropertyEquals('timeout_seconds', $seconds);
        $this->assertPropertyEquals('timeout_microseconds', $micros);
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
        $this->class->set_timeout($seconds, $micros);

        $this->assertFalse($seconds === $this->get_reflection_property_value('timeout_seconds'));
        $this->assertFalse($micros === $this->get_reflection_property_value('timeout_microseconds'));
    }

    /**
     * Tests that the set timeout method with default microseconds parameter.
     *
     * @covers Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutWithDefaultMicroseconds()
    {
        $value = $this->get_reflection_property_value('timeout_microseconds');

        $this->class->set_timeout(1);

        $this->assertTrue(1 === $this->get_reflection_property_value('timeout_seconds'));
        $this->assertTrue(0 === $this->get_reflection_property_value('timeout_microseconds'));
        $this->assertPropertySame('timeout_microseconds', $value);
    }

    /**
     * Test the fluid interface of the set_context_option() method.
     *
     * @covers Lunr\Network\StreamSocket::set_context_option
     */
    public function testSetContextOptionReturnsSelfReference()
    {
        $return = $this->class->set_context_option('http', 'method', 'POST');

        $this->assertEquals($return, $this->class);
    }

    /**
     * Test the fluid interface of the set_context_options() method.
     *
     * @covers Lunr\Network\StreamSocket::set_context_options
     */
    public function testSetContextOptionsReturnsSelfReference()
    {
        $value = ['http' => ['method' => 'POST']];

        $return = $this->class->set_context_options($value);

        $this->assertEquals($return, $this->class);
    }

    /**
     * Test the fluid interface of the set_blocking() method.
     *
     * @covers Lunr\Network\StreamSocket::set_blocking
     */
    public function testSetBlockingReturnsSelfReference()
    {
        $return = $this->class->set_blocking(0);

        $this->assertEquals($return, $this->class);
    }

    /**
     * Test the fluid interface of the set_notification_callback() method.
     *
     * @covers Lunr\Network\StreamSocket::set_notification_callback
     */
    public function testSetNotificationCallbackReturnsSelfReference()
    {
        $return = $this->class->set_notification_callback('notification');

        $this->assertEquals($return, $this->class);
    }

    /**
     * Test the fluid interface of the set_timeout() method.
     *
     * @covers Lunr\Network\StreamSocket::set_timeout
     */
    public function testSetTimeoutReturnsSelfReference()
    {
        $return = $this->class->set_timeout(1);

        $this->assertEquals($return, $this->class);
    }

}

?>
