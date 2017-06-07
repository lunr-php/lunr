<?php

/**
 * This file contains the SessionBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Sphere
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;
use PHPUnit\Framework\Error\Warning as PHPUnit_Framework_Error_Warning;

/**
 * This class contains tests for the Session class.
 *
 * @covers Lunr\Sphere\Session
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
     * @covers Lunr\Sphere\Session::setSessionHandler
     */
    public function testSetSessionHandlerReturnsTrueWithSessionHandlerInterface()
    {
        $handler = $this->getMockBuilder('\SessionHandlerInterface')->getMock();

        $this->assertTrue($this->class->setSessionHandler($handler));
    }

    /**
     * Test that setSessionHandler returns false when receives invalid data.
     *
     * @param mixed $handler Invalid Session handler
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      invalidSessionHandlerProvider
     * @covers            Lunr\Sphere\Session::setSessionHandler
     */
    public function testSetSessionHandlerReturnsFalseWithInvalidData($handler)
    {
        $this->assertFalse($this->class->setSessionHandler($handler));
    }

    /**
     * Test that set doesn't do anything when closed and not started.
     *
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * @backupGlobals enabled
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
     * Test that sessionId works properly.
     *
     * @covers   Lunr\Sphere\Session::sessionId
     */
    public function testGetSessionId()
    {
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->assertEquals('myId', $this->class->sessionId());
        $this->unmock_function('session_id');
    }

    /**
     * Test that setSessionId works properly.
     *
     * @covers   Lunr\Sphere\Session::setSessionId
     */
    public function testSetSessionId()
    {
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->class->setSessionId('hello');
        $this->assertEquals('hello', $this->class->sessionId());
        $this->unmock_function('session_id');
    }

    /**
     * Test that regenerateId works properly.
     *
     * @covers   Lunr\Sphere\Session::regenerateId
     */
    public function testGetNewSessionId()
    {
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);
        $this->mock_function('session_regenerate_id', self::FUNCTION_RETURN_TRUE);

        $oldId = $this->class->sessionId();

        session_id('newId');
        $newId = $this->class->regenerateId();

        $this->assertNotEquals($oldId, $newId);
        $this->unmock_function('session_id');
        $this->unmock_function('session_regenerate_id');
    }

    /**
     * Test that start works properly.
     *
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
     * Test that resume works properly.
     *
     * @requires extension runkit
     * @covers   \Lunr\Sphere\Session::resume
     */
    public function testResume()
    {
        $this->set_reflection_property_value('started', TRUE);
        $this->set_reflection_property_value('closed', FALSE);

        $this->class->resume('2');

        $this->assertTrue($this->get_reflection_property_value('started'));
        $this->assertFalse($this->get_reflection_property_value('closed'));
    }

    /**
     * Test that resume works properly when closed.
     *
     * @requires extension runkit
     * @covers   \Lunr\Sphere\Session::resume
     */
    public function testResumeWhenClosed()
    {
        $this->set_reflection_property_value('started', FALSE);
        $this->set_reflection_property_value('closed', TRUE);

        $this->mock_function('session_start', self::FUNCTION_RETURN_TRUE);
        $this->mock_function('session_id', self::FUNCTION_GENERATE_ID);

        $this->class->resume('2');

        $this->assertTrue($this->get_reflection_property_value('started'));
        $this->assertFalse($this->get_reflection_property_value('closed'));
        $this->unmock_function('session_start');
        $this->unmock_function('session_id');
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
        $this->assertEquals('newId', $this->class->sessionId());
        $this->unmock_function('session_id');
        $this->unmock_function('session_start');
    }

    /**
     * Test that destroy works properly when started.
     *
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
     * @backupGlobals enabled
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
