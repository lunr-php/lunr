<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectListFilesTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for directory related methods in the PhysicalFilesystemAccessObject.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectListFilesTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test listing files in an accessible directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInAccessibleDirectory()
    {
        $expected = [ 'file1', 'file2' ];

        $value = $this->class->get_list_of_files($this->find_location);

        $this->assertInternalType('array', $value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test listing files in an inaccessible directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInInaccessibleDirectory()
    {
        $directory = '/root';

        $error = "DirectoryIterator::__construct($directory): failed to open dir: Permission denied";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test listing files in an non-existant directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInNonExistantDirectory()
    {
        $directory = '/tmp56474q';

        $error = "DirectoryIterator::__construct($directory): failed to open dir: No such file or directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test listing files in a file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    public function testGetListOfFilesInFile()
    {
        $directory = tempnam('/tmp', 'phpunit_');

        $error = "DirectoryIterator::__construct($directory): failed to open dir: Not a directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test listing files in an invalid directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    Public function testGetListOfFilesInNullDirectory()
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_files(NULL);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test listing files in an invalid directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    Public function testGetListOfFilesInObjectDirectory()
    {
        $directory = new \stdClass();

        $error = 'DirectoryIterator::__construct() expects parameter 1 to be string, object given';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->get_list_of_files($directory);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test listing files in an boolean directory.
     *
     * @param Boolean $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::get_list_of_files
     */
    Public function testGetListOfFilesInBooleanTrueDirectory($directory)
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_list_of_files($directory);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

}

?>
