<?php

/**
 * This file contains the DatabaseSessionHandlerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Sphere\Tests;

/**
 * This class contains tests for the constructor of the DatabaseSessionHandler class.
 *
 * @category   Libraries
 * @package    Sphere
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Sphere\DatabaseSessionHandler
 */
class DatabaseSessionHandlerBaseTest extends DatabaseSessionHandlerTest
{

    /**
     * Test that lifetime is initialized properly.
     */
    public function testDefaultLifetimeValue()
    {
        $this->assertPropertyEquals('lifetime', ini_get('session.gc_maxlifetime'));
    }

    /**
     * Test open function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::open
     */
    public function testOpenPath()
    {
        $this->assertTrue($this->class->open('myPath', ''));
    }

    /**
     * Test close function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::close
     */
    public function testCloseReturnsTrue()
    {
        $this->assertTrue($this->class->close());
    }

    /**
     * Test read function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::read
     */
    public function testReadReadsFromDatabase()
    {
        $this->sdao->expects($this->once())
                   ->method('read_session_data')
                   ->with($this->equalTo('sessionid'))
                   ->will($this->returnValue([]));
        $this->assertSame([], $this->class->read('sessionid'));
    }

    /**
     * Test write function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::write
     */
    public function testWriteWritesInDatabase()
    {
        $this->sdao->expects($this->once())
                   ->method('write_session_data')
                   ->with($this->equalTo('sessionid'), $this->equalTo('sessionData'))
                   ->will($this->returnValue(TRUE));
        $this->assertTrue($this->class->write('sessionid', 'sessionData'));
    }

    /**
     * Test destroy function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::destroy
     */
    public function testDestroyDeletesSession()
    {
        $this->sdao->expects($this->once())
                   ->method('delete_session')
                   ->with($this->equalTo('sessionid'));

        $this->assertTrue($this->class->destroy('sessionid'));
    }

    /**
     * Test gc function.
     *
     * @covers Lunr\Sphere\DatabaseSessionHandler::gc
     */
    public function testGcCollectsSession()
    {
        $this->sdao->expects($this->once())
                   ->method('session_gc')
                   ->with($this->equalTo('10'));

        $this->assertTrue($this->class->gc(10));
    }

}

?>
