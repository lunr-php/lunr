<?php

/**
 * This file contains the StreamSocketClientReadwriteTest class.
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
 * This class contains test methods for read and write methods of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientReadWriteTest extends StreamSocketClientTest
{

    /**
     * Tests that read() returns a string on success.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringOnSuccess()
    {
        runkit_function_redefine('fread', '', self::STREAM_SOCKET_CLIENT_RETURN_STRING);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->stream_socket_client->read(8)));

        unlink('./test.txt');
    }

    /**
     * Tests that read() returns a string with no lenght supplied.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringWithNoLengthSupplied()
    {
        runkit_function_redefine('stream_get_contents', '', self::STREAM_SOCKET_CLIENT_RETURN_STRING);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->stream_socket_client->read()));

        unlink('./test.txt');
    }

    /**
     * Tests that read() returns a string with zero lenght supplied.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsStringWithZeroLengthSupplied()
    {
        runkit_function_redefine('stream_get_contents', '', self::STREAM_SOCKET_CLIENT_RETURN_STRING);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_string($this->stream_socket_client->read(-1)));

        unlink('./test.txt');
    }

    /**
     * Tests that read() returns FALSE on error.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsFalseOnError()
    {
        runkit_function_redefine('stream_get_contents', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertFalse($this->stream_socket_client->read(8));

        unlink('./test.txt');
    }

    /**
     * Tests that read() create handle if stream not open.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadOpensHandle()
    {
        runkit_function_redefine('stream_get_contents', '', self::STREAM_SOCKET_CLIENT_RETURN_STRING);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->stream_socket_client));

        $this->stream_socket_client->read(8);

        $this->assertNotNull($property->getValue($this->stream_socket_client));

        unlink('./test.txt');
    }

    /**
     * Tests that read() returns FALSE if cannot open stream.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::read
     */
    public function testReadReturnsFalseIfCannotOpenStream()
    {
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertFalse($this->stream_socket_client->read(8));

        $this->assertNull($property->getValue($this->stream_socket_client));
    }

    /**
     * Tests that write() returns an int on success.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsIntOnSuccess()
    {
        runkit_function_redefine('fwrite', '', self::STREAM_SOCKET_CLIENT_RETURN_EIGHT);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue(is_int($this->stream_socket_client->write('12345678')));
    }

    /**
     * Tests that write() returns FALSE on error.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsFalseOnError()
    {
        runkit_function_redefine('fwrite', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertFalse($this->stream_socket_client->write('12345678'));

        unlink('./test.txt');
    }

    /**
     * Tests that write() create handle if stream not open.
     *
     * @runInSeparateProcess
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::write
     */
    public function testWriteOpensHandle()
    {
        runkit_function_redefine('fwrite', '', self::STREAM_SOCKET_CLIENT_RETURN_EIGHT);

        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->stream_socket_client));

        $this->stream_socket_client->write('12345678');

        $this->assertNotNull($property->getValue($this->stream_socket_client));

        unlink('./test.txt');
    }

    /**
     * Tests that write() returns FALSE if cannot open stream.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers Lunr\Network\StreamSocketClient::write
     */
    public function testWriteReturnsFalseIfCannotOpenStream()
    {
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertFalse($this->stream_socket_client->write('12345678'));
        $this->assertNull($property->getValue($this->stream_socket_client));
    }

}

?>
