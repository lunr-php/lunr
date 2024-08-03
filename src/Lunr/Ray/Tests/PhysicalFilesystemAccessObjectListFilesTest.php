<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectListFilesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectListFilesTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing files in an accessible directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInAccessibleDirectory(): void
    {
        $expected = [ 'file1', 'file2', 'file3' ];

        $value = $this->class->get_list_of_files($this->find_location);

        $this->assertIsArray($value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing files in an inaccessible directory.
     *
     * @requires OS Linux
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInInaccessibleDirectory(): void
    {
        $directory = '/root';

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: Permission denied";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: Permission denied";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing files in an non-existent directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInNonExistentDirectory(): void
    {
        $directory = '/tmp56474q';

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: No such file or directory";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: No such file or directory";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing files in a file.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInFile(): void
    {
        $directory = tempnam('/tmp', 'phpunit_');

        if (PHP_VERSION_ID >= 80000)
        {
            $error = "DirectoryIterator::__construct($directory): Failed to open directory: Not a directory";
        }
        else
        {
            $error = "DirectoryIterator::__construct($directory): failed to open dir: Not a directory";
        }

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertArrayEmpty($value);

        unlink($directory);
    }

    /**
     * Test listing files in an boolean directory.
     *
     * @param bool $directory Boolean directory value
     *
     * @requires     PHP < 8
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInBooleanTrueDirectory($directory): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_files($directory);

        $this->assertArrayEmpty($value);
    }

}

?>
