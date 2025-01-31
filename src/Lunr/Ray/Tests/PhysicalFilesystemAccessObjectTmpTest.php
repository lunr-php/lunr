<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTmpTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectTmpTest extends PhysicalFilesystemAccessObjectTestCase
{

    /**
     * Test that get_tmp_file() returns a file from tempnam.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_tmp_file
     */
    public function testGetTmpFileSucceedsWithoutPrefix(): void
    {
        $fetched = $this->class->get_tmp_file();

        $this->assertFileExists($fetched);
    }

    /**
     * Test that get_tmp_file() returns a file from tempnam with the provided prefix.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_tmp_file
     */
    public function testGetTmpFileSucceedsWithPrefix(): void
    {
        $fetched = $this->class->get_tmp_file('prefix');

        if (method_exists($this, 'assertMatchesRegularExpression'))
        {
            $this->assertMatchesRegularExpression('/prefix/', $fetched);
        }
        else
        {
            $this->assertRegExp('/prefix/', $fetched);
        }

        $this->assertFileExists($fetched);
    }

}

?>
