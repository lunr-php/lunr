<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTmpTest class.
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

/**
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectRmTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that rm() returns false if rm fails.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::rm
     */
    public function testRmFails(): void
    {
        $fetched = FALSE;
        try
        {
            $fetched = $this->class->rm('/root/tmp');
        }
        catch (\Throwable $notice)
        {
            //NO-OP
        }
        finally
        {
            $this->assertFalse($fetched);
        }

    }

    /**
     * Test that rm() returns true on success.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::rm
     */
    public function testRmSucceeds(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        $this->assertFileExists($file);

        $rm = $this->class->rm($file);

        $this->assertTrue($rm);
        $this->assertFileNotExists($file);
    }

}

?>
