<?php

/**
 * This file contains the StreamSocketClientReadwriteTest class.
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
 * This class contains test methods for read and write methods of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientReadWriteTest extends StreamSocketClientTest
{

    /**
     * Tests that read() returns a string on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringOnSuccess()
    {
        $this->mock_function('fread', self::STREAM_SOCKET_CLIENT_RETURN_STRING);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->class->read(8)));

        unlink('./test.txt');

        $this->unmock_function('fread');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that read() returns a string with no lenght supplied.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringWithNoLengthSupplied()
    {
        $this->mock_function('stream_get_contents', self::STREAM_SOCKET_CLIENT_RETURN_STRING);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->class->read()));

        unlink('./test.txt');

        $this->unmock_function('stream_get_contents');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that read() returns a string with zero lenght supplied.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringWithZeroLengthSupplied()
    {
        $this->mock_function('stream_get_contents', self::STREAM_SOCKET_CLIENT_RETURN_STRING);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->class->read(-1)));

        unlink('./test.txt');

        $this->unmock_function('stream_get_contents');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that read() returns FALSE on error.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsFalseOnError()
    {
        $this->mock_function('stream_get_contents', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertFalse($this->class->read(8));

        unlink('./test.txt');

        $this->unmock_function('stream_get_contents');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that read() create handle if stream not open.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadOpensHandle()
    {
        $this->mock_function('stream_get_contents', self::STREAM_SOCKET_CLIENT_RETURN_STRING);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertNull($this->get_reflection_property_value('handle'));

        $this->class->read(8);

        $this->assertNotNull($this->get_reflection_property_value('handle'));

        unlink('./test.txt');

        $this->unmock_function('stream_get_contents');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that read() returns FALSE if cannot open stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsFalseIfCannotOpenStream()
    {
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $this->assertFalse($this->class->read(8));

        $this->assertNull($this->get_reflection_property_value('handle'));
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that write() returns an int on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsIntOnSuccess()
    {
        $this->mock_function('fwrite', self::STREAM_SOCKET_CLIENT_RETURN_EIGHT);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_int($this->class->write('12345678')));
        $this->unmock_function('fwrite');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that write() returns FALSE on error.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsFalseOnError()
    {
        $this->mock_function('fwrite', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertFalse($this->class->write('12345678'));

        unlink('./test.txt');

        $this->unmock_function('fwrite');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that write() create handle if stream not open.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::write
     */
    public function testWriteOpensHandle()
    {
        $this->mock_function('fwrite', self::STREAM_SOCKET_CLIENT_RETURN_EIGHT);
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertNull($this->get_reflection_property_value('handle'));

        $this->class->write('12345678');

        $this->assertNotNull($this->get_reflection_property_value('handle'));

        unlink('./test.txt');

        $this->unmock_function('fwrite');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that write() returns FALSE if cannot open stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsFalseIfCannotOpenStream()
    {
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $this->assertFalse($this->class->write('12345678'));
        $this->assertNull($this->get_reflection_property_value('handle'));

        $this->unmock_function('stream_socket_client');
    }

}

?>
