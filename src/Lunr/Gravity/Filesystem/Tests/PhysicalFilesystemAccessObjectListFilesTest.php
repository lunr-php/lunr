<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectListFilesTest class.
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectListFilesTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing files in an accessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
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
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInInaccessibleDirectory(): void
    {
        $directory = '/root';

        $error = "DirectoryIterator::__construct($directory): failed to open dir: Permission denied";

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
     * Test listing files in an non-existant directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInNonExistantDirectory(): void
    {
        $directory = '/tmp56474q';

        $error = "DirectoryIterator::__construct($directory): failed to open dir: No such file or directory";

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
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInFile(): void
    {
        $directory = tempnam('/tmp', 'phpunit_');

        $error = "DirectoryIterator::__construct($directory): failed to open dir: Not a directory";

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
     * Test listing files in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInNullDirectory(): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_files(NULL);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing files in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInObjectDirectory(): void
    {
        $directory = new \stdClass();

        $error = 'DirectoryIterator::__construct() expects parameter 1 to be a valid path, object given';

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
     * Test listing files in an boolean directory.
     *
     * @param boolean $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_files
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
