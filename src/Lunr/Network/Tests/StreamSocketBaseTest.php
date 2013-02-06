<?php

/**
 * This file contains the StreamSocketBaseTest class.
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
 * This class contains basic test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketBaseTest extends StreamSocketTest
{

    /**
     * Tests that context_options is an empty array by default.
     */
    public function testContextOptionsIsEmptyArray()
    {
        $property = $this->stream_socket_reflection->getProperty('context_options');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->stream_socket);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Tests that meta data info is an empty array by default.
     */
    public function testMetaDataIsEmptyArray()
    {
        $property = $this->stream_socket_reflection->getProperty('meta_data');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->stream_socket);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Tests that flags is an empty array by default.
     */
    public function testFlagsIsEmptyArray()
    {
        $property = $this->stream_socket_reflection->getProperty('flags');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->stream_socket);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Tests that error_number equals 0 by default.
     */
    public function testErrorNumberIsZero()
    {
        $property = $this->stream_socket_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that blocking equals TRUE by default.
     */
    public function testBlockingIsOne()
    {
        $property = $this->stream_socket_reflection->getProperty('blocking');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->stream_socket));
    }

    /**
     * Tests that error_message is an empty string by default.
     */
    public function testErrorMessageIsEmptyString()
    {
        $property = $this->stream_socket_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->stream_socket));
    }

    /**
     * Tests that notification is an empty string by default.
     */
    public function testNotificationIsNull()
    {
        $property = $this->stream_socket_reflection->getProperty('notification');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->stream_socket));
    }

    /**
     * Tests that handle is NULL by default.
     */
    public function testHandleIsNull()
    {
        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->stream_socket));
    }

    /**
     * Tests that context is NULL by default.
     */
    public function testContextIsNull()
    {
        $property = $this->stream_socket_reflection->getProperty('context');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->stream_socket));
    }

    /**
     * Tests that timeout_seconds equals 60 by default.
     */
    public function testTimeoutSecondsInitValue()
    {
        $property = $this->stream_socket_reflection->getProperty('timeout_seconds');
        $property->setAccessible(TRUE);

        $this->assertEquals(60, $property->getValue($this->stream_socket));
    }

    /**
     * Tests that timeout_micros equals 0 by default.
     */
    public function testTimeoutMicrosEqualsZero()
    {
        $property = $this->stream_socket_reflection->getProperty('timeout_microseconds');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->stream_socket));
    }

}

?>
