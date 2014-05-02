<?php

/**
 * This file contains the PhysicalFilesystemRemoveDirectoryTest class.
 *
 * PHP Version 5.4
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for removing a directory recursively.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemRemoveDirectoryTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that rmdir() removes the given directory and its contents.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::rmdir
     */
    public function testRemoveDirectory()
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
        $this->assertFileNotExists($directory);
    }

    /**
     * Test rmdir() with an non-existant directory.
     *
     * @param mixed  $directory String or object directory value
     * @param String $error     The respective to the input error message
     *
     * @dataProvider invalidFilepathValueProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::rmdir
     */
    public function testRemoveDirectoryWithInvalidDirectory($directory, $error)
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
     * @dataProvider emptyFilepathValueProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::rmdir
     */
    Public function testRemoveDirectoryInEmptyDirectory($directory)
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('{message}', ['message' => 'Directory name must not be empty.']);

        $this->assertFalse($this->class->rmdir($directory));
    }

}

?>
