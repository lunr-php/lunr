<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectDirectoryTest class.
 *
 * PHP Version 5.4
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
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
        $expected = [ 'file1', 'file2', 'folder1', 'folder2' ];

        $value = $this->class->get_directory_listing($this->find_location);

        $this->assertInternalType('array', $value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing  an inaccessible directory.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfInaccessibleDirectory()
    {
        $directory = '/root';

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing an non-existant directory.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfNonExistantDirectory()
    {
        $directory = '/tmp56474q';

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing a file.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    public function testGetListingOfFile()
    {
        $directory = tempnam('/tmp', 'phpunit_');;

        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing an invalid directory.
     *
     * @param mixed $directory Invalid directory value
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      invalidNameProvider
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    Public function testGetListingOfInvalidDirectory($directory)
    {
        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing an boolean directory.
     *
     * @param Boolean $directory Boolean directory value
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      booleanNameProvider
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_directory_listing
     */
    Public function testGetListingOfBooleanDirectory($directory)
    {
        $value = $this->class->get_directory_listing($directory);

        $this->assertArrayEmpty($value);
    }

}

?>
