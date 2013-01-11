<?php

/**
 * This file contains the StreamSocketClientBaseTest class.
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
 * This class contains basic test methods for the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientBaseTest extends StreamSocketClientTest
{

    /**
     * Tests that the stream socket client inits with the transmitted uri value through constructor.
     *
     * @covers Lunr\Network\StreamSocketClient::__construct
     */
    public function testUriIntisWithProvidedValue()
    {
        $stream = new \Lunr\Network\StreamSocketClient('alinktosee');

        $property = $this->stream_socket_client_reflection->getProperty('uri');
        $property->setAccessible(TRUE);

        $this->assertEquals('alinktosee', $property->getValue($stream));

        unset($stream);
    }

    /**
     * Tests that the stream socket client inits with default connection time out.
     *
     * @covers Lunr\Network\StreamSocketClient::__construct
     */
    public function testTimeoutIntisWithDefault()
    {
        $property = $this->stream_socket_client_reflection->getProperty('init_timeout');
        $property->setAccessible(TRUE);

        $this->assertEquals(ini_get('default_socket_timeout'), $property->getValue($this->stream_socket_client));
        $this->assertTrue(is_float($property->getValue($this->stream_socket_client)));
    }

    /**
     * Tests that the stream socket client inits with provided valid connection time out.
     *
     * @param Integer $value    The value to set
     * @param Integer $expected The expected result
     *
     * @dataProvider validInitTimeoutProvider
     * @covers       Lunr\Network\StreamSocketClient::__construct
     */
    public function testTimeoutIntisWithValidValue($value, $expected)
    {
        $stream = new \Lunr\Network\StreamSocketClient('alinktosee', $value);

        $property = $this->stream_socket_client_reflection->getProperty('init_timeout');
        $property->setAccessible(TRUE);

        $this->assertEquals($expected, $property->getValue($stream));

        unset($stream);
    }

    /**
     * Tests that the init doesn't set the time out when invalid value provided.
     *
     * @param mixed $value The value to set
     *
     * @dataProvider invalidInitTimeoutProvider
     * @depends      Lunr\Network\Tests\StreamSocketClientBaseTest::testTimeoutIntisWithValidValue
     * @covers       Lunr\Network\StreamSocketClient::__construct
     */
    public function testTimeoutInitsWithInvalidValue($value)
    {
        $stream = new \Lunr\Network\StreamSocketClient('alinktosee', $value);

        $property = $this->stream_socket_client_reflection->getProperty('init_timeout');
        $property->setAccessible(TRUE);

        $this->assertEquals(floatval(ini_get('default_socket_timeout')), $property->getValue($stream));
        $this->assertTrue($value !== $property->getValue($stream));

        unset($stream);
    }

    /**
     * Tests that the connected flag is FALSE by default.
     *
     * @covers Lunr\Network\StreamSocketClient::__construct
     */
    public function testConnectedIsFalse()
    {
        $property = $this->stream_socket_client_reflection->getProperty('connected');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->stream_socket_client));
    }

}

?>