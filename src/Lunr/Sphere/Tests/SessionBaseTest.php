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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Sphere\Session
 */
class SessionBaseTest extends SessionTest
{

    /**
     * Test that closed is initialized properly.
     */
    public function testDefaultClosedValue()
    {
        $this->assertFalse($this->get_reflection_property_value('closed'));
    }

    /**
     * Test that started is initialized properly.
     */
    public function testDefaultStartedValue()
    {
        $this->assertFalse($this->get_reflection_property_value('started'));
    }

    /**
     * Test that setSessionHandler returns true when receives a SessionHandlerInterface.
     *
     * @covers Lunr\Sphere\Session::set_session_handler
     */
    public function testSetSessionHandlerReturnsTrueWithSessionHandlerInterface()
    {
        $handler = $this->getMock('\SessionHandlerInterface');

        $this->assertTrue($this->class->set_session_handler($handler));
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
        $this->assertFalse($this->class->set_session_handler($handler));
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
        $_SESSION = [];

        $method = $this->get_accessible_reflection_method('set');

        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', TRUE);

        $method->invokeArgs($this->class, ['key', 'value']);

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
        $_SESSION = [];

        $method = $this->get_accessible_reflection_method('set');

        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', FALSE);

        $method->invokeArgs($this->class, ['key', 'value']);

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
        $_SESSION = [];

        $method = $this->get_accessible_reflection_method('set');

        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', TRUE);

        $method->invokeArgs($this->class, ['key', 'value']);

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
        $method = $this->get_accessible_reflection_method('set');

        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', FALSE);

        $method->invokeArgs($this->class, ['key', 'value']);

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
        $method = $this->get_accessible_reflection_method('delete');

        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', TRUE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->class, ['key']);

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
        $method = $this->get_accessible_reflection_method('delete');

        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', FALSE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->class, ['key']);

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
        $method = $this->get_accessible_reflection_method('delete');

        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', TRUE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->class, ['key']);

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
        $_SESSION = [];
        $method   = $this->get_accessible_reflection_method('delete');

        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', FALSE);

        $_SESSION['key'] = 'value';

        $method->invokeArgs($this->class, ['key']);

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
        $method = $this->get_accessible_reflection_method('get');

        $this->set_reflection_property_value('started', FALSE);

        $_SESSION['key'] = 'value';

        $this->assertNull($method->invokeArgs($this->class, ['key']));
    }

    /**
     * Test that get doesn't do anything when key is not stored in SESSION.
     *
     * @covers Lunr\Sphere\Session::get
     */
    public function testGetReturnsNullWhenNoKey()
    {
        $method = $this->get_accessible_reflection_method('get');

        $this->set_reflection_property_value('started', TRUE);

        $this->assertNull($method->invokeArgs($this->class, ['key']));
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
        $method = $this->get_accessible_reflection_method('get');

        $this->set_reflection_property_value('started', TRUE);

        $_SESSION['key'] = 'value';

        $this->assertEquals('value', $method->invokeArgs($this->class, ['key']));
    }

    /**
     * Test that get_session_id works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::get_session_id
     */
    public function testGetSessionId()
    {
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->assertEquals('myId', $this->class->get_session_id());
        $this->unmock_function('session_id');
    }

    /**
     * Test that get_new_session_id works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::get_new_session_id
     */
    public function testGetNewSessionId()
    {
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->mock_function('session_regenerate_id', self::FUNCTION_RETURN_TRUE);

        $oldId = $this->class->get_session_id();

        session_id('newId');
        $newId = $this->class->get_new_session_id();

        $this->assertNotEquals($oldId, $newId);
        $this->unmock_function('session_id');
        $this->unmock_function('session_regenerate_id');
    }

    /**
     * Test that start works properly.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::start
     */
    public function testStart()
    {
        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', TRUE);

        $this->mock_function('session_start', self::FUNCTION_RETURN_TRUE);

        $this->class->start();

        $this->assertTrue($this->get_reflection_property_value('started'));
        $this->assertFalse($this->get_reflection_property_value('closed'));
        $this->unmock_function('session_start');
    }

    /**
     * Test that start works properly.
     *
     * @covers Lunr\Sphere\Session::start
     */
    public function testStartIfAlreadyStarted()
    {
        $this->set_reflection_property_value('started', TRUE);

        $this->class->start();

        $this->assertTrue($this->get_reflection_property_value('started'));
        $this->assertFalse($this->get_reflection_property_value('closed'));
    }

    /**
     * Test that start works properly setting an id.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::start
     */
    public function testStartSetsId()
    {
        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', TRUE);

        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->mock_function('session_start', self::FUNCTION_RETURN_TRUE);

        $this->class->start('newId');

        $this->assertTrue($this->get_reflection_property_value('started'));
        $this->assertFalse($this->get_reflection_property_value('closed'));
        $this->assertEquals('newId', $this->class->get_session_id());
        $this->unmock_function('session_id');
        $this->unmock_function('session_start');
    }

    /**
     * Test that destroy works properly when started.
     *
     * @requires extension runkit
     * @covers   Lunr\Sphere\Session::destroy
     */
    public function testDestroyWorksWhenStarted()
    {
        $this->set_reflection_property_value('started', TRUE);

        $_SESSION['key'] = 'value';

        $this->mock_function('session_destroy', self::FUNCTION_RETURN_TRUE);

        $this->class->destroy();

        $this->assertEquals([], $_SESSION);
        $this->unmock_function('session_destroy');
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
        $this->set_reflection_property_value('started', FALSE);

        $_SESSION['key'] = 'value';

        $this->class->destroy();

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
        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', FALSE);

        $this->mock_function('session_write_close', self::FUNCTION_RETURN_TRUE);

        $this->class->close();

        $this->assertFalse($this->get_reflection_property_value('started'));
        $this->assertTrue($this->get_reflection_property_value('closed'));
        $this->unmock_function('session_write_close');
    }

}

?>
