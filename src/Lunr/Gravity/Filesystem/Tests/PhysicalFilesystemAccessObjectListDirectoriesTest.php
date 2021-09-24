<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectListDirectoriesTest class.
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
class PhysicalFilesystemAccessObjectListDirectoriesTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing directories in an accessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInAccessibleDirectory(): void
    {
        $expected = [ 'Database', 'folder1', 'folder2' ];

        $value = $this->class->get_list_of_directories($this->find_location);

        $this->assertIsArray($value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing directories in an inaccessible directory.
     *
     * @requires OS Linux
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInInaccessibleDirectory(): void
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

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in an non-existant directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInNonExistantDirectory(): void
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

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in a file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInFile(): void
    {
        $directory = tempnam('/tmp', 'phpunit_');;

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => "DirectoryIterator::__construct($directory): failed to open dir: Not a directory",
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);

        unlink($directory);
    }

    /**
     * Test listing directories in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInNullDirectory(): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('{message}', [ 'message' => 'Directory name must not be empty.' ]);

        $value = $this->class->get_list_of_directories(NULL);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInObjectDirectory(): void
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

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test listing directories in an boolean directory.
     *
     * @param boolean $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_list_of_directories
     */
    public function testGetListOfDirectoriesInBooleanDirectory($directory): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_directories($directory);

        $this->assertArrayEmpty($value);
    }

}

?>
