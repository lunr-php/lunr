<?php

/**
 * This file contains the StreamSocketClientFlagsTest class.
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
 * This class contains test methods for flags of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientFlagsTest extends StreamSocketClientTest
{

    /**
     * Tests that a valid flag is properly added if not present.
     *
     * @covers Lunr\Network\StreamSocketClient::add_flag
     */
    public function testAddValidFlagIfNotPresent()
    {
        $property = $this->stream_socket_client_reflection->getProperty('flags');
        $property->setAccessible(TRUE);

        $previous = $property->getValue($this->stream_socket_client);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $property->getValue($this->stream_socket_client);

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_PERSISTENT, $new);

        $previous = $property->getValue($this->stream_socket_client);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_ASYNC_CONNECT');

        $new = $property->getValue($this->stream_socket_client);

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_ASYNC_CONNECT, $new);
    }

    /**
     * Tests that a valid flag is not added if present.
     *
     * @covers Lunr\Network\StreamSocketClient::add_flag
     */
    public function testDoNotAddValidFlagIfPresent()
    {
        $property = $this->stream_socket_client_reflection->getProperty('flags');
        $property->setAccessible(TRUE);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_PERSISTENT');

        $previous = $property->getValue($this->stream_socket_client);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $property->getValue($this->stream_socket_client);

        $this->assertEquals($previous, $new);
    }

    /**
     * Tests that an invalid flag is not added to flags.
     *
     * @dataProvider invalidFlagProvider
     * @covers       Lunr\Network\StreamSocketClient::add_flag
     */
    public function testDoNotAddInvalidFlag()
    {
        $property = $this->stream_socket_client_reflection->getProperty('flags');
        $property->setAccessible(TRUE);

        $previous = $property->getValue($this->stream_socket_client);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $property->getValue($this->stream_socket_client);

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_PERSISTENT, $new);
    }

    /**
     * Tests that create_flags() merges the given int to the total.
     *
     * @covers Lunr\Network\StreamSocketClient::create_flags
     */
    public function testCreateFlags()
    {
        $method = $this->stream_socket_client_reflection->getMethod('create_flags');
        $method->setAccessible(TRUE);

        $this->assertEquals(3, $method->invokeArgs($this->stream_socket_client, array(2, 1)));
    }

}

?>
