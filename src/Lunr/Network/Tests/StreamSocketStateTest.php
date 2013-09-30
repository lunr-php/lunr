<?php

/**
 * This file contains the StreamSocketStateTest class.
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
 * This class contains test methods for state change StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(TRUE, FALSE, FALSE));

        $this->assertTrue($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() method returns FALSE if the stream cannot be read.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnReadWatchOfTheStreamIfNotChanged()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(TRUE, FALSE, FALSE));

        $this->assertFalse($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching read availability of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnReadWatchOfTheStreamIfError()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(TRUE, FALSE, FALSE));

        $this->assertNull($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() method returns TRUE if the stream can be written.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsTrueOnWriteWatchOfTheStreamIfChanged()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, TRUE, FALSE));

        $this->assertTrue($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() method returns FALSE if the stream cannot be written.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnWriteWatchOfTheStreamIfNotChanged()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, TRUE, FALSE));

        $this->assertFalse($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching write availability of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnWriteWatchOfTheStreamIfError()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, TRUE, FALSE));

        $this->assertNull($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() method returns TRUE if the stream has thrown an exception.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsTrueOnExceptionWatchOfTheStreamIfChanged()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertTrue($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() method returns FALSE if the stream has not thrown an exception.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsFalseOnExceptionWatchOfTheStreamIfNotChanged()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertFalse($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() returns NULL if error occurs while watching exception purpose of the stream.
     *
     * @requires extension runkit
     * @covers   Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullOnexceptionWatchOfTheStreamIfError()
    {
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertNull($return);

        unlink('./test.txt');
    }

    /**
     * Tests that changed() returns NULL if stream is not open for all type of watch.
     *
     * @covers Lunr\Network\StreamSocket::changed
     */
    public function testChangedReturnsNullIfStreamNotOpened()
    {
        $method = $this->stream_socket_reflection->getMethod('changed');
        $method->setAccessible(TRUE);

        $return = $method->invokeArgs($this->stream_socket, array(TRUE, FALSE, FALSE));
        $this->assertNull($return);

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, TRUE, FALSE));
        $this->assertNull($return);

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));
        $this->assertNull($return);
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertTrue($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertFalse($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertNull($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_write');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertTrue($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_write');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertFalse($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_write');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invoke($this->stream_socket);

        $this->assertNull($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ONE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read_exceptional_data');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertTrue($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_ZERO);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read_exceptional_data');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertFalse($return);

        unlink('./test.txt');
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
        runkit_function_redefine('stream_select', '', self::STREAM_SOCKET_RETURN_FALSE);

        $method = $this->stream_socket_reflection->getMethod('is_ready_to_read_exceptional_data');
        $method->setAccessible(TRUE);

        $property = $this->stream_socket_reflection->getProperty('handle');
        $property->setAccessible(TRUE);
        //to prevent the method to try to create the handle
        $property->setValue($this->stream_socket, fopen('./test.txt', 'a'));

        $return = $method->invokeArgs($this->stream_socket, array(FALSE, FALSE, TRUE));

        $this->assertNull($return);

        unlink('./test.txt');
    }

}

?>
