<?php

/**
 * This file contains the StreamSocketStateTest class.
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
 * This class contains test methods for state change StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketStateTest extends StreamSocketTest
{

    /**
     * Tests that changed() method returns TRUE if the stream can be read.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsTrueOnReadWatchOfTheStreamIfChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invokeArgs($this->class, [TRUE, FALSE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() method returns FALSE if the stream cannot be read.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnReadWatchOfTheStreamIfNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('changed');

        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invokeArgs($this->class, [TRUE, FALSE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching read availability of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnReadWatchOfTheStreamIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('changed');

        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invokeArgs($this->class, [TRUE, FALSE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() method returns TRUE if the stream can be written.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsTrueOnWriteWatchOfTheStreamIfChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('changed');

        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invokeArgs($this->class, [FALSE, TRUE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() method returns FALSE if the stream cannot be written.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnWriteWatchOfTheStreamIfNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invokeArgs($this->class, [FALSE, TRUE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching write availability of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnWriteWatchOfTheStreamIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invokeArgs($this->class, [FALSE, TRUE, FALSE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() method returns TRUE if the stream has thrown an exception.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsTrueOnExceptionWatchOfTheStreamIfChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() method returns FALSE if the stream has not thrown an exception.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnExceptionWatchOfTheStreamIfNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching exception purpose of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnexceptionWatchOfTheStreamIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('changed');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that changed() returns NULL if stream is not open for all type of watch.
     *
     * @covers Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullIfStreamNotOpened()
    {
        $method = $this->get_accessible_reflection_method('changed');

        $this->assertNull($method->invokeArgs($this->class, [TRUE, FALSE, FALSE]));
        $this->assertNull($method->invokeArgs($this->class, [FALSE, TRUE, FALSE]));
        $this->assertNull($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));
    }

    /**
     * Tests that is_ready_to_read() returns TRUE if the stream can be read.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsTrueOnReadWatchOfTheStreamIfChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read
     */
    public function testIsReadyToReadReturnsTrueIfStreamChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('is_ready_to_read');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_read() method returns FALSE if the stream cannot be read.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsFalseOnReadWatchOfTheStreamIfNotChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read
     */
    public function testIsReadyToReadReturnsFalseIfStreamNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('is_ready_to_read');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_read() returns NULL if error occurs while watching read availability of the stream.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsNullOnReadWatchOfTheStreamIfError
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read
     */
    public function testIsReadyToReadReturnsNullIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('is_ready_to_read');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_write() method returns TRUE if the stream can be written.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsTrueOnWriteWatchOfTheStreamIfChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_write
     */
    public function testIsReadyToWriteReturnsTrueIfStreamChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('is_ready_to_write');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_write() method returns FALSE if the stream cannot be written.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsFalseOnWriteWatchOfTheStreamIfNotChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_write
     */
    public function testIsReadyToWriteReturnsFalseIfStreamNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('is_ready_to_write');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_write() returns NULL if error occurs while watching write availability of the stream.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsNullOnWriteWatchOfTheStreamIfError
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_write
     */
    public function testIsReadyToWriteReturnsNullIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('is_ready_to_write');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invoke($this->class));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_read_exceptional_data() returns TRUE if the stream has thrown an exception.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsTrueOnExceptionWatchOfTheStreamIfChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read_exceptional_data
     */
    public function testIsReadyToreadExceptionnalDataReturnsTrueIfStreamChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->get_accessible_reflection_method('is_ready_to_read_exceptional_data');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertTrue($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_read_exceptional_data() returns FALSE if the stream has not exceptional data.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsFalseOnExceptionWatchOfTheStreamIfNotChanged
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read_exceptional_data
     */
    public function testIsReadyToreadExceptionnalDataReturnsFalseIfStreamNotChanged()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->get_accessible_reflection_method('is_ready_to_read_exceptional_data');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertFalse($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

    /**
     * Tests that is_ready_to_read_exceptional_data() returns NULL if error occurs.
     *
     * @depends  Lunr\Network\Tests\StreamSocketStateTest::testChangedReturnsNullOnexceptionWatchOfTheStreamIfError
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::is_ready_to_read_exceptional_data
     */
    public function testIsReadyToreadExceptionnalDataReturnsNullIfError()
    {
        $this->mock_function('stream_select', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->get_accessible_reflection_method('is_ready_to_read_exceptional_data');

        //to prevent the method to try to create the handle
        $this->set_reflection_property_value('handle', fopen('./test.txt', 'a'));

        $this->assertNull($method->invokeArgs($this->class, [FALSE, FALSE, TRUE]));

        unlink('./test.txt');

        $this->unmock_function('stream_select');
    }

}

?>
