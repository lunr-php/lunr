<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectDirectoryTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

use Throwable;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectDirectoryTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing an accessible directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfAccessibleDirectory(): void
    {
        $expected = [ 'file1', 'file2', 'file3', 'folder1', 'folder2' ];

        $value = $this->class->get_directory_listing($this->find_location);

        $this->assertIsArray($value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing  an inaccessible directory.
     *
     * @requires OS Linux
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfInaccessibleDirectory(): void
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

        $directory = '/root';

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing an non-existent directory.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfNonExistentDirectory(): void
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

        $directory = '/tmp56474q';

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing a file.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfFile(): void
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

        $directory = tempnam('/tmp', 'phpunit_');;

        try
        {
            $value = $this->class->get_directory_listing($directory);
        }
        catch (Throwable $e)
        {
            throw $e;
        }
        finally
        {
            unlink($directory);
        }
    }

    /**
     * Test listing an boolean directory.
     *
     * @param bool $directory Boolean directory value
     *
     * @requires     PHP < 8
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfBooleanDirectory($directory): void
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

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

}

?>
