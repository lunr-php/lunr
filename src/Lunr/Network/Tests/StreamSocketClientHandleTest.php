<?php

/**
 * This file contains the StreamSocketClientHandleTest class.
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
 * This class contains test methods for stream handle resource of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientHandleTest extends StreamSocketClientTest
{

    /**
     * Tests that the call of create_handle() sets the handle to a resource.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandle()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $method = $this->get_accessible_reflection_method('create_handle');

        $method->invoke($this->class);

        $this->assertTrue(is_resource($this->get_reflection_property_value('handle')));

        unlink('./test.txt');

        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that create_handle() returns FALSE if error occurs.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleReturnsFalseOnError()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('create_handle');

        $this->assertFalse($method->invoke($this->class));
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that the call of connect creates the handle.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenCreatesHandle()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->class->connect();

        $this->assertTrue(is_resource($this->get_reflection_property_value('handle')));

        unlink('./test.txt');

        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that the call of connect with a previously connected handle keeps it the same.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenTwiceKeepsSameHandle()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->class->connect();

        $first = $this->get_reflection_property_value('handle');

        $this->unmock_function('stream_socket_client');
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_OTHER_HANDLE);

        $this->class->connect();

        $second = $this->get_reflection_property_value('handle');

        $this->assertEquals($first, $second);

        unlink('./test.txt');

        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that connect() returns FALSE if error occurs.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::connect
     */
    public function testOpenReturnsFalseOnError()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $this->assertFalse($this->class->connect());
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that the call of disconnect() method sets the handle to null.
     *
     * @covers Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseDestroysHandle()
    {
        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue(is_resource($this->get_reflection_property_value('handle')));
        $this->assertTrue($this->class->disconnect());
        $this->assertNull($this->get_reflection_property_value('handle'));

        unlink('./test.txt');
    }

    /**
     * Tests that the call of disconnect() returns TRUE if handle is NULL.
     *
     * @covers Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsTrueIfHandleIsNull()
    {
        $this->assertTrue($this->class->disconnect());
    }

    /**
     * Tests that the call of disconnect() returns FALSE if error occurs.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsFalseIfError()
    {
        $this->mock_function('fclose', self::STREAM_SOCKET_CLIENT_RETURN_FALSE);

        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($this->class->disconnect());
        $this->unmock_function('fclose');
    }

    /**
     * Tests that the call of disconnect() return TRUE on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::disconnect
     */
    public function testCloseReturnsTrueOnSuccess()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $this->assertTrue($this->class->connect());

        $this->mock_function('fclose', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);

        $this->assertTrue($this->class->disconnect());
        $this->unmock_function('fclose');
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that create_handle() updates the meta_data.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleUpdatesMetaData()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $first = $this->get_reflection_property_value('handle');

        $method = $this->get_accessible_reflection_method('create_handle');

        $method->invoke($this->class);

        $second = $this->get_reflection_property_value('handle');

        $this->assertNotEquals($first, $second);
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

    /**
     * Tests that the addition of proper flags leads to a handle creation.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocketClient::create_handle
     */
    public function testCreateHandleWithFlags()
    {
        $this->mock_function('stream_set_timeout', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_set_blocking', self::STREAM_SOCKET_CLIENT_RETURN_TRUE);
        $this->mock_function('stream_socket_client', self::STREAM_SOCKET_CLIENT_RETURN_HANDLE);

        $method = $this->get_accessible_reflection_method('create_handle');

        $this->class->add_flag('STREAM_CLIENT_ASYNC_CONNECT');
        $this->class->add_flag('STREAM_CLIENT_PERSISTENT');

        $method->invoke($this->class);

        $this->assertNotNull($this->get_reflection_property_value('handle'));
        $this->unmock_function('stream_set_timeout');
        $this->unmock_function('stream_set_blocking');
        $this->unmock_function('stream_socket_client');
    }

}

?>
