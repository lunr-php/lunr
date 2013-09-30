<?php

/**
 * This file contains the SessionBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

/**
 * This class contains tests for the Session class.
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Sphere\Session
 */
class SessionBaseTest extends SessionTest
{

    /**
     * Test that closed is initialized properly.
     */
    public function testDefaultClosedValue()
    {
        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->session);

        $this->assertFalse($value);
    }

    /**
     * Test that started is initialized properly.
     */
    public function testDefaultStartedValue()
    {
        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->session);

        $this->assertFalse($value);
    }

    /**
     * Test that setSessionHandler returns true when receives a SessionHandlerInterface.
     *
     * @covers Lunr\Sphere\Session::set_session_handler
     */
    public function testSetSessionHandlerReturnsTrueWithSessionHandlerInterface()
    {
        $handler = $this->getMock('\SessionHandlerInterface');

        $this->assertTrue($this->session->set_session_handler($handler));
    }

    /**
     * Test that setSessionHandler returns false when receives invalid data.
     *
     * @param mixed $handler Invalid Session handler
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      invalidSessionHandlerProvider
     * @covers            Lunr\Sphere\Session::set_session_handler
     */
    public function testSetSessionHandlerReturnsFalseWithInvalidData($handler)
    {
        $this->assertFalse($this->session->set_session_handler($handler));
    }

    /**
     * Test that set doesn't do anything when closed and not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::set
     */
    public function testSetIsIgnoredWhenClosedAndNotStarted()
    {
        $_SESSION = array();
        $method   = $this->session_reflection->getMethod('set');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $method->invokeArgs($this->session, array('key', 'value'));

        $this->assertArrayNotHasKey('key', $_SESSION);
    }

    /**
     * Test that set doesn't do anything when not closed and not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::set
     */
    public function testSetIsIgnoredWhenNotClosedAndNotStarted()
    {
        $_SESSION = array();
        $method   = $this->session_reflection->getMethod('set');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $method->invokeArgs($this->session, array('key', 'value'));

        $this->assertArrayNotHasKey('key', $_SESSION);
    }

    /**
     * Test that set doesn't do anything when closed and started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::set
     */
    public function testSetIsIgnoredWhenClosedAndStarted()
    {
        $_SESSION = array();
        $method   = $this->session_reflection->getMethod('set');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $method->invokeArgs($this->session, array('key', 'value'));

        $this->assertArrayNotHasKey('key', $_SESSION);
    }

    /**
     * Test that set works when not closed and started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::set
     */
    public function testSetWorksWhenNotClosedAndStarted()
    {
        $method = $this->session_reflection->getMethod('set');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $method->invokeArgs($this->session, array('key', 'value'));

        $this->assertArrayHasKey('key', $_SESSION);
        $this->assertEquals($_SESSION['key'], 'value');
    }

    /**
     * Test that delete doesn't do anything when closed and not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::delete
     */
    public function testDeleteIsIgnoredWhenClosedAndNotStarted()
    {
        $method = $this->session_reflection->getMethod('delete');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->session, array('key'));

        $this->assertArrayHasKey('key', $_SESSION);
    }

    /**
     * Test that delete doesn't do anything when not closed and not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::delete
     */
    public function testDeleteIsIgnoredWhenNotClosedAndNotStarted()
    {
        $method = $this->session_reflection->getMethod('delete');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->session, array('key'));

        $this->assertArrayHasKey('key', $_SESSION);
    }

    /**
     * Test that delete doesn't do anything when closed and started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::delete
     */
    public function testDeleteIsIgnoredWhenClosedAndStarted()
    {
        $method = $this->session_reflection->getMethod('delete');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->session, array('key'));

        $this->assertArrayHasKey('key', $_SESSION);
    }

    /**
     * Test that delete works when not closed and started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::delete
     */
    public function testDeleteWorksWhenNotClosedAndStarted()
    {
        $_SESSION = array();
        $method   = $this->session_reflection->getMethod('delete');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $property = $this->session_reflection->getProperty('closed');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->session, array('key'));

        $this->assertArrayNotHasKey('key', $_SESSION);
    }

    /**
     * Test that get doesn't do anything when not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::get
     */
    public function testGetReturnsNullWhenNotStarted()
    {
        $method = $this->session_reflection->getMethod('get');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, FALSE);

        $_SESSION['key'] = 'value';

        $this->assertNull($method->invokeArgs($this->session, array('key')));
    }

    /**
     * Test that get doesn't do anything when key is not stored in SESSION.
     *
     * @covers Lunr\Sphere\Session::get
     */
    public function testGetReturnsNullWhenNoKey()
    {
        $method = $this->session_reflection->getMethod('get');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $this->assertNull($method->invokeArgs($this->session, array('key')));
    }

    /**
     * Test that get works when started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::get
     */
    public function testGetWorksWhenStarted()
    {
        $method = $this->session_reflection->getMethod('get');

        $property = $this->session_reflection->getProperty('started');
        $property->setAccessible(TRUE);
        $property->setValue($this->session, TRUE);

        $_SESSION['key'] = 'value';

        $this->assertEquals('value', $method->invokeArgs($this->session, array('key')));
    }

    /**
     * Test that get_session_id works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::get_session_id
     */
    public function testGetSessionId()
    {
        runkit_function_redefine('session_id', '', self::FUNCTION_GENERATE_ID);

        $this->assertEquals('myId', $this->session->get_session_id());
    }

    /**
     * Test that get_new_session_id works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::get_new_session_id
     */
    public function testGetNewSessionId()
    {
        runkit_function_redefine('session_id', '', self::FUNCTION_GENERATE_ID);
        runkit_function_redefine('session_regenerate_id', '', self::FUNCTION_RETURN_TRUE);

        $oldId = $this->session->get_session_id();

        //This is the only way I know to set a new session ID using the redefined functions we have.
        session_id('newId');
        $newId = $this->session->get_new_session_id();

        $this->assertNotEquals($oldId, $newId);
    }

    /**
     * Test that start works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::start
     */
    public function testStart()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, FALSE);

        $closed = $this->session_reflection->getProperty('closed');
        $closed->setAccessible(TRUE);
        $closed->setValue($this->session, TRUE);

        runkit_function_redefine('session_start', '', self::FUNCTION_RETURN_TRUE);

        $this->session->start();

        $this->assertTrue($started->getValue($this->session));
        $this->assertFalse($closed->getValue($this->session));
    }

    /**
     * Test that start works properly.
     *
     * @covers Lunr\Sphere\Session::start
     */
    public function testStartIfAlreadyStarted()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, TRUE);

        $closed = $this->session_reflection->getProperty('closed');
        $closed->setAccessible(TRUE);

        $this->session->start();

        $this->assertTrue($started->getValue($this->session));
        $this->assertFalse($closed->getValue($this->session));
    }

    /**
     * Test that start works properly setting an id.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::start
     */
    public function testStartSetsId()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, FALSE);

        $closed = $this->session_reflection->getProperty('closed');
        $closed->setAccessible(TRUE);
        $closed->setValue($this->session, TRUE);

        runkit_function_redefine('session_id', '', self::FUNCTION_GENERATE_ID);
        runkit_function_redefine('session_start', '', self::FUNCTION_RETURN_TRUE);

        $this->session->start('newId');

        $this->assertTrue($started->getValue($this->session));
        $this->assertFalse($closed->getValue($this->session));
        $this->assertEquals('newId', $this->session->get_session_id());
    }

    /**
     * Test that destroy works properly when started.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::destroy
     */
    public function testDestroyWorksWhenStarted()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, TRUE);

        $_SESSION['key'] = 'value';

        runkit_function_redefine('session_destroy', '', self::FUNCTION_RETURN_TRUE);

        $this->session->destroy();

        $this->assertEquals(array(), $_SESSION);
    }

    /**
     * Test that destroy doesn't work when not started.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Sphere\Session::destroy
     */
    public function testDestroyDoesNothingWhenNotStarted()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, FALSE);

        $_SESSION['key'] = 'value';

        $this->session->destroy();

        $this->assertArrayHasKey('key', $_SESSION);
    }

    /**
     * Test that close.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::close
     */
    public function testCloseSetsParameters()
    {
        $started = $this->session_reflection->getProperty('started');
        $started->setAccessible(TRUE);
        $started->setValue($this->session, TRUE);

        $closed = $this->session_reflection->getProperty('closed');
        $closed->setAccessible(TRUE);
        $closed->setValue($this->session, FALSE);

        runkit_function_redefine('session_write_close', '', self::FUNCTION_RETURN_TRUE);

        $this->session->close();

        $this->assertFalse($started->getValue($this->session));
        $this->assertTrue($closed->getValue($this->session));
    }

}

?>
