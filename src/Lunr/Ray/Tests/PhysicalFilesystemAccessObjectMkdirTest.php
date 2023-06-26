<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectMkdirTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

use Lunr\Ray\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for creating a directory.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectMkdirTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that mkdir() returns FALSE when access mode is a string.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirReturnsFalseWhenAccessModeIsString(): void
    {
        $directory = TEST_STATICS . '/Ray/test_directory';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('String representation of access mode is not supported. Please, try using an integer.'));

        $this->assertFalse($this->class->mkdir($directory, '0777'));
    }

    /**
     * Test that mkdir() returns FALSE when access mode is invalid.
     *
     * @param mixed $mode Invalid mode value
     *
     * @dataProvider invalidDirModeValuesProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirReturnsFalseWhenAccessModeIsInvalid($mode): void
    {
        $directory = TEST_STATICS . '/Ray/test_directory';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('Access mode value ' . $mode . ' is invalid.'));

        $this->assertFalse($this->class->mkdir($directory, $mode));
    }

    /**
     * Test that mkdir() returns FALSE when fails to create a directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenFailsToCreateADirectory(): void
    {
        $directory = TEST_STATICS . '/Ray/test_directory';

        $this->mock_function('mkdir', function (){return FALSE;});

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('Failed to create directory: ' . $directory));

        $this->assertFalse($this->class->mkdir($directory));

        $this->unmock_function('mkdir');
    }

    /**
     * Test that mkdir() returns TRUE when creates a directory.
     *
     * @param int $mode Valid mode value
     *
     * @dataProvider validDirModeValuesProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenCreatesADirectory($mode): void
    {
        $directory = TEST_STATICS . '/Ray/test_directory';

        $this->assertTrue($this->class->mkdir($directory, $mode));
        $this->assertFileExists($directory);

        rmdir($directory);
    }

    /**
     * Test that mkdir() returns TRUE when creates more than one nested directories.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenCreatesADirectoryRecursively(): void
    {
        $directory = TEST_STATICS . '/Ray/test_directory/nested_dir';

        $this->assertTrue($this->class->mkdir($directory, 0777, TRUE));
        $this->assertFileExists($directory);

        rmdir($directory);
        rmdir(TEST_STATICS . '/Ray/test_directory');
    }

}

?>
