<?php

/**
 * This file contains the LunrSQLite3Test class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\LunrSQLite3;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the LunrSQLite3 class.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\LunrSQLite3
 */
class LunrSQLite3Test extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        if (extension_loaded('sqlite3') === FALSE)
        {
            $this->markTestSkipped('Extension sqlite3 is required.');
        }

        $this->class      = new LunrSQLite3();
        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\LunrSQLite3');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test that busyTimeout throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testBusyTimeoutThrowsWarning()
    {
        $this->assertFALSE($this->class->busyTimeout(1000));
    }

    /**
     * Test that changes throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testChangesThrowsWarning()
    {
        $this->assertEquals(0, $this->class->changes());
    }

    /**
     * Test that close does not throw a warning because we are not yet connected.
     */
    public function testCloseDoesNotThrowWarning()
    {
        $this->assertTrue($this->class->close());
    }

    /**
     * Test that escapeString does not throw a warning because we are not yet connected.
     */
    public function testEscapeStringDoesNotThrowWarning()
    {
        $this->assertEquals("Don''t", $this->class->escapeString("Don't"));
    }

    /**
     * Test that exec throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testExecThrowsWarning()
    {
        $this->assertFalse($this->class->exec('Test'));
    }

    /**
     * Test that lastErrorCode throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testLastErrorCodeThrowsWarning()
    {
        $this->assertEquals(0, $this->class->lastErrorCode());
    }

    /**
     * Test that lastErrorMsg throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testLastErrorMsgThrowsWarning()
    {
        $this->assertEquals(0, $this->class->lastErrorMsg());
    }

    /**
     * Test that lastInsertRowID throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testLastInsertRowIDThrowsWarning()
    {
        $this->assertEquals(0, $this->class->lastInsertRowID());
    }

    /**
     * Test that prepare throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testPrepareThrowsWarning()
    {
        $this->assertFalse($this->class->prepare('Test'));
    }

    /**
     * Test that query throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testQueryThrowsWarning()
    {
        $this->assertFalse($this->class->query('Test'));
    }

    /**
     * Test that querySingle throws a warning because we are not yet connected.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testQuerySingleThrowsWarning()
    {
        $this->assertFalse($this->class->querySingle('Test'));
    }

    /**
     * Test that version does not throw a warning because we are not yet connected.
     */
    public function testVersionDoesNotThrowWarning()
    {
        $this->assertInternalType('array', $this->class->version());
    }

}
