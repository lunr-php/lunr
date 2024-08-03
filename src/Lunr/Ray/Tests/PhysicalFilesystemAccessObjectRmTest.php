<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTmpTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

use Throwable;

/**
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectRmTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that rm() returns false if rm fails.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::rm
     */
    public function testRmFails(): void
    {
        $fetched = FALSE;
        try
        {
            $fetched = $this->class->rm('/root/tmp');
        }
        catch (Throwable $notice)
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
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::rm
     */
    public function testRmSucceeds(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        $this->assertFileExists($file);

        $rm = $this->class->rm($file);

        $this->assertTrue($rm);
        if (method_exists($this, 'assertFileDoesNotExist'))
        {
            $this->assertFileDoesNotExist($file);
        }
        else
        {
            $this->assertFileNotExists($file);
        }
    }

}

?>
