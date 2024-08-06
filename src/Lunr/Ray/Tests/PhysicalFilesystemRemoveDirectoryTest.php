<?php

/**
 * This file contains the PhysicalFilesystemRemoveDirectoryTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for removing a directory recursively.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemRemoveDirectoryTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that rmdir() removes the given directory and its contents.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::rmdir
     */
    public function testRemoveDirectory(): void
    {
        $directory   = tempnam('/tmp', 'lunr_rmdir_');
        $directory_2 = $directory . '/directory2';

        unlink($directory);
        mkdir($directory, 0777, TRUE);
        mkdir($directory_2, 0777, TRUE);
        touch($directory . '/file1');
        touch($directory_2 . '/file2');

        $this->assertFileExists($directory);
        $this->assertTrue($this->class->rmdir($directory));
        if (method_exists($this, 'assertFileDoesNotExist'))
        {
            $this->assertFileDoesNotExist($directory);
        }
        else
        {
            $this->assertFileNotExists($directory);
        }
    }

    /**
     * Test rmdir() with an non-existent directory.
     *
     * @param mixed  $directory String or object directory value
     * @param string $error     The respective to the input error message
     *
     * @requires OS Linux
     *
     * @dataProvider invalidFilepathValueProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::rmdir
     */
    public function testRemoveDirectoryWithInvalidDirectory($directory, $error): void
    {
        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($this->equalTo("Couldn't recurse on directory '{directory}': {message}"),
                            $this->equalTo([ 'message' => $error, 'directory' => $directory ]));

        $this->assertFalse($this->class->rmdir($directory));
    }

    /**
     * Test rmdir() in an empty value directory.
     *
     * @param mixed $directory NULL or FALSE directory value
     *
     * @requires     PHP < 8
     * @dataProvider emptyFilepathValueProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::rmdir
     */
    public function testRemoveDirectoryInEmptyDirectory($directory): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('{message}', [ 'message' => 'Directory name must not be empty.' ]);

        $this->assertFalse($this->class->rmdir($directory));
    }

}

?>
