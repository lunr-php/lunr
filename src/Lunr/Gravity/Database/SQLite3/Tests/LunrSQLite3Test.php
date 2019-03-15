<?php

/**
 * This file contains the LunrSQLite3Test class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\LunrSQLite3;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the LunrSQLite3 class.
 *
 * @covers Lunr\Gravity\Database\SQLite3\LunrSQLite3
 */
class LunrSQLite3Test extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
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
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test that busyTimeout throws a warning because we are not yet connected.
     */
    public function testBusyTimeoutThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertFALSE($this->class->busyTimeout(1000));
    }

    /**
     * Test that changes throws a warning because we are not yet connected.
     */
    public function testChangesThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertEquals(0, $this->class->changes());
    }

    /**
     * Test that close does not throw a warning because we are not yet connected.
     */
    public function testCloseDoesNotThrowWarning(): void
    {
        $this->assertTrue($this->class->close());
    }

    /**
     * Test that escapeString does not throw a warning because we are not yet connected.
     */
    public function testEscapeStringDoesNotThrowWarning(): void
    {
        $this->assertEquals("Don''t", $this->class->escapeString("Don't"));
    }

    /**
     * Test that exec throws a warning because we are not yet connected.
     */
    public function testExecThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertFalse($this->class->exec('Test'));
    }

    /**
     * Test that lastErrorCode throws a warning because we are not yet connected.
     */
    public function testLastErrorCodeThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertEquals(0, $this->class->lastErrorCode());
    }

    /**
     * Test that lastErrorMsg throws a warning because we are not yet connected.
     */
    public function testLastErrorMsgThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertEquals(0, $this->class->lastErrorMsg());
    }

    /**
     * Test that lastInsertRowID throws a warning because we are not yet connected.
     */
    public function testLastInsertRowIDThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertEquals(0, $this->class->lastInsertRowID());
    }

    /**
     * Test that prepare throws a warning because we are not yet connected.
     */
    public function testPrepareThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertFalse($this->class->prepare('Test'));
    }

    /**
     * Test that query throws a warning because we are not yet connected.
     */
    public function testQueryThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertFalse($this->class->query('Test'));
    }

    /**
     * Test that querySingle throws a warning because we are not yet connected.
     */
    public function testQuerySingleThrowsWarning(): void
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException('\PHPUnit\Framework\Error\Warning');
        }
        else
        {
            // PHPUnit 5
            $this->expectException('\PHPUnit_Framework_Error_Warning');
        }

        $this->assertFalse($this->class->querySingle('Test'));
    }

    /**
     * Test that version does not throw a warning because we are not yet connected.
     */
    public function testVersionDoesNotThrowWarning(): void
    {
        $this->assertIsArray($this->class->version());
    }

}
