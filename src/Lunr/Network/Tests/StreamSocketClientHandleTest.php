<?php

/**
 * This file contains the StreamSocketClientHandleTest class.
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
 * This class contains test methods for stream handle resource of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientHandleTest extends StreamSocketClientTest
{

    /**
     * Tests that the call of create_handle() sets the handle to a resource.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandle()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $method = $this->stream_socket_client_reflection->getMethod('create_handle');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket_client);

        $this->assertTrue(is_resource($property->getValue($this->stream_socket_client)));

        unlink('./test.txt');
    }

    /**
     * Tests that create_handle() returns FALSE if error occurs.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleReturnsFalseOnError()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $method = $this->stream_socket_client_reflection->getMethod('create_handle');
        $method->setAccessible(TRUE);

        $this->assertFalse($method->invoke($this->stream_socket_client));
    }

    /**
     * Tests that the call of connect creates the handle.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenCreatesHandle()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->stream_socket_client->connect();

        $this->assertTrue(is_resource($property->getValue($this->stream_socket_client)));

        unlink('./test.txt');
    }

    /**
     * Tests that the call of connect with a previously connected handle keeps it the same.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenTwiceKeepsSameHandle()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->stream_socket_client->connect();

        $first = $property->getValue($this->stream_socket_client);

        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_OTHER_HANDLE);

        $this->stream_socket_client->connect();

        $second = $property->getValue($this->stream_socket_client);

        $this->assertEquals($first, $second);

        unlink('./test.txt');
    }

    /**
     * Tests that connect() returns FALSE if error occurs.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenReturnsFalseOnError()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $this->assertFalse($this->stream_socket_client->connect());
    }

    /**
     * Tests that the call of disconnect() method sets the handle to null.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseDestroysHandle()
    {
        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $connect = $this->stream_socket_client_reflection->getProperty('connected');
        $connect->setAccessible(TRUE);
        $connect->setValue($this->stream_socket_client, TRUE);

        $property->setValue($this->stream_socket_client, fopen('./test.txt', 'a'));

        $this->assertTrue(is_resource($property->getValue($this->stream_socket_client)));

        $this->assertTrue($this->stream_socket_client->disconnect());

        $this->assertNull($property->getValue($this->stream_socket_client));

        unlink('./test.txt');
    }

    /**
     * Tests that the call of disconnect() returns TRUE if handle is NULL.
     *
     * @covers Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsTrueIfHandleIsNull()
    {
        $this->assertTrue($this->stream_socket_client->disconnect());
    }

    /**
     * Tests that the call of disconnect() returns FALSE if error occurs.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsFalseIfError()
    {
        $copy = 'tmpdisconnect';
        runkit_function_copy('fclose', $copy);
        runkit_function_redefine('fclose', '', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $connect = $this->stream_socket_client_reflection->getProperty('connected');
        $connect->setAccessible(TRUE);
        $connect->setValue($this->stream_socket_client, TRUE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        $property->setValue($this->stream_socket_client, fopen('./test.txt', 'a'));

        $this->assertFalse($this->stream_socket_client->disconnect());

        runkit_function_remove('fclose');
        runkit_function_rename($copy, 'fclose');

    }

    /**
     * Tests that the call of disconnect() return TRUE on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsTrueOnSuccess()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue($this->stream_socket_client->connect());
        runkit_function_redefine('fclose', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);

        $this->assertTrue($this->stream_socket_client->disconnect());

    }

    /**
     * Tests that create_handle() updates the meta_data.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleUpdatesMetaData()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $first = $property->getValue($this->stream_socket_client);

        $method = $this->stream_socket_client_reflection->getMethod('create_handle');
        $method->setAccessible(TRUE);

        $method->invoke($this->stream_socket_client);

        $second = $property->getValue($this->stream_socket_client);

        $this->assertNotEquals($first, $second);
    }

    /**
     * Tests that the addition of proper flags leads to a handle creation.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleWithFlags()
    {
        runkit_function_redefine('stream_set_timeout', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_set_blocking', '', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        runkit_function_redefine('stream_socket_client', '', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $property = $this->stream_socket_client_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $method = $this->stream_socket_client_reflection->getMethod('create_handle');
        $method->setAccessible(TRUE);

        $this->stream_socket_client->add_flag('STREAM_CLIENT_ASYNC_CONNECT');
        $this->stream_socket_client->add_flag('STREAM_CLIENT_PERSISTENT');

        $method->invoke($this->stream_socket_client);

        $this->assertNotNull($property->getValue($this->stream_socket_client));
    }

}

?>
