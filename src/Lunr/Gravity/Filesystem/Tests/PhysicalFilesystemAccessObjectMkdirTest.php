<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectMkdirTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for creating a directory.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectMkdirTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that mkdir() returns FALSE when access mode is a string.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirReturnsFalseWhenAccessModeIsString()
    {
        $directory = TEST_STATICS . '/Gravity/test_directory';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('String representation of access mode is not supported. Please, try using an integer.'));

        $this->assertFalse($this->class->mkdir($directory, '0777'));
    }

    /**
     * Test that mkdir() returns FALSE when access mode is invalid.
     *
     * @dataProvider invalidDirModeValues
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirReturnsFalseWhenAccessModeIsInvalid($mode)
    {
        $directory = TEST_STATICS . '/Gravity/test_directory';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('Access mode value ' . $mode . ' is invalid.'));

        $this->assertFalse($this->class->mkdir($directory, $mode));
    }

    /**
     * Test that mkdir() returns FALSE when fails to create a directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenFailsToCreateADirectory()
    {
        $directory = TEST_STATICS . '/Gravity/test_directory';

        $this->mock_function('mkdir', 'return FALSE;');

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->EqualTo('Failed to create directory: ' . $directory));

        $this->assertFalse($this->class->mkdir($directory));

        $this->unmock_function('mkdir');
    }

    /**
     * Test that mkdir() returns TRUE when creates a directory.
     *
     * @dataProvider validDirModeValues
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenCreatesADirectory($mode)
    {
        $directory = TEST_STATICS . '/Gravity/test_directory';

        $this->assertTrue($this->class->mkdir($directory, $mode));
        $this->assertFileExists($directory);

        rmdir($directory);
    }

    /**
     * Test that mkdir() returns TRUE when creates more than one nested directories.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::mkdir
     */
    public function testMkdirWhenCreatesADirectoryRecursively()
    {
        $directory = TEST_STATICS . '/Gravity/test_directory/nested_dir';

        $this->assertTrue($this->class->mkdir($directory, 0777, TRUE));
        $this->assertFileExists($directory);

        rmdir($directory);
        rmdir(TEST_STATICS . '/Gravity/test_directory');
    }

}

?>
