<?php

/**
 * This file contains the DatabaseSessionHandlerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains tests for the constructor of the DatabaseSessionHandler class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Core\DataBaseSessionHandler
 */
class DatabaseSessionHandlerBaseTest extends DatabaseSessionHandlerTest
{

    /**
     * Test that lifetime is initialized properly.
     */
    public function testDefaultLifetimeValue()
    {
        $property = $this->dsh_reflection->getProperty('lifetime');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->dsh);

        $this->assertEquals(ini_get('session.gc_maxlifetime'), $value);
    }

    /**
     * Test open function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::open
     */
    public function testOpenPath()
    {
        $this->assertTrue($this->dsh->open('myPath', ''));
    }

    /**
     * Test close function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::close
     */
    public function testCloseReturnsTrue()
    {
        $this->assertTrue($this->dsh->close());
    }

    /**
     * Test read function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::read
     */
    public function testReadReadsFromDatabase()
    {
        $this->sdao->expects($this->once())
                   ->method('read_session_data')
                   ->with($this->equalTo('sessionid'))
                   ->will($this->returnValue(array()));
        $this->assertSame(array(), $this->dsh->read('sessionid'));
    }

    /**
     * Test write function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::write
     */
    public function testWriteWritesInDatabase()
    {
        $this->sdao->expects($this->once())
                   ->method('write_session_data')
                   ->with($this->equalTo('sessionid'), $this->equalTo('sessionData'))
                   ->will($this->returnValue(TRUE));
        $this->assertTrue($this->dsh->write('sessionid', 'sessionData'));
    }

    /**
     * Test destroy function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::destroy
     */
    public function testDestroyDeletesSession()
    {
        $this->sdao->expects($this->once())
                   ->method('delete_session')
                   ->with($this->equalTo('sessionid'));

        $this->assertTrue($this->dsh->destroy('sessionid'));
    }

    /**
     * Test gc function.
     *
     * @covers Lunr\Core\DataBaseSessionHandler::gc
     */
    public function testGcCollectsSession()
    {
        $this->sdao->expects($this->once())
                   ->method('session_gc')
                   ->with($this->equalTo('10'));

        $this->assertTrue($this->dsh->gc(10));
    }

}

?>
