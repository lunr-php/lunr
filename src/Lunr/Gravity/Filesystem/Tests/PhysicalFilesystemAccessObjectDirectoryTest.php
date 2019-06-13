<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectDirectoryTest class.
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;
use Throwable;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectDirectoryTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing an accessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfAccessibleDirectory()
    {
        $expected = [ 'file1', 'file2', 'file3', 'folder1', 'folder2' ];

        $value = $this->class->get_directory_listing($this->find_location);

        $this->assertInternalType('array', $value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing  an inaccessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfInaccessibleDirectory()
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
     * Test listing an non-existant directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfNonExistantDirectory()
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
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfFile()
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
     * Test listing an invalid directory.
     *
     * @param mixed $directory Invalid directory value
     *
     * @dataProvider invalidNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfInvalidDirectory($directory)
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

    /**
     * Test listing an boolean directory.
     *
     * @param boolean $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfBooleanDirectory($directory)
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
