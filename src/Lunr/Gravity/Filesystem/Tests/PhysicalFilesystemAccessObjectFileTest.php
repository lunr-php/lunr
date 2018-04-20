<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectFileTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Filesystem\Tests;

use Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject;

/**
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectFileTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that get_file_content() gets contents of an accessible file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithAccessibleFile()
    {
        $file = TEST_STATICS . '/Gravity/file1';

        $content = "Content\n";

        $fetched = $this->class->get_file_content($file);

        $this->assertEquals($content, $fetched);
    }

    /**
     * Test that get_file_content() does not get contents of an inaccessible file.
     *
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithInaccessibleFile()
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $file = '/root/ab45cd89';

        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() does not get contents of a non-existant file.
     *
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithNonExistantFile()
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $file = sys_get_temp_dir() . '/ab45cd89';

        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() does not get contents of a directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentOfDirectory()
    {
        $file = sys_get_temp_dir();

        $fetched = $this->class->get_file_content($file);

        $this->assertEquals('', $fetched);
    }

    /**
     * Test that get_file_content() with invalid file names.
     *
     * @param mixed $file Invalid filename
     *
     * @dataProvider      invalidNameProvider
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithInvalidFilenames($file)
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() with invalid file names.
     *
     * @param Boolean $file Boolean filename
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithBooleanFilenames($file)
    {
        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that put_file_content() puts contents in an accessible file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithAccessibleFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFileEquals(TEST_STATICS . '/Gravity/file1', $file);
        $this->assertEquals(8, $written);
    }

    /**
     * Test that put_file_content() does not put contents in an inaccessible file.
     *
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithInaccessibleFile()
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $file = '/root/ab45cd89';

        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() puts contents in a non-existant file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithNonExistantFile()
    {
        $file = sys_get_temp_dir() . '/ab65cd89';

        $this->assertFalse(file_exists($file));

        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFileEquals(TEST_STATICS . '/Gravity/file1', $file);
        $this->assertEquals(8, $written);
        unlink($file);
    }

    /**
     * Test that put_file_content() does not put contents in a directory.
     *
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentInDirectory()
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $file = sys_get_temp_dir();

        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() with invalid file names.
     *
     * @param mixed $file Invalid filename
     *
     * @dataProvider      invalidNameProvider
     * @covers            Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithInvalidFilenames($file)
    {
        if (class_exists('\PHPUnit\Framework\Error\Warning'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Warning::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        }

        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() with boolean file names.
     *
     * @param Boolean $file Boolean filename
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithBooleanFilenames($file)
    {
        $content = "Content\n";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() appends the content to the file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentAppendsToFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $content = "Content\n";

        $this->class->put_file_content($file, $content);
        $this->class->put_file_content($file, $content, TRUE);

        $this->assertFileEquals(TEST_STATICS . '/Gravity/file3', $file);
    }

    /**
     * Test that put_file_content() acquires an exclusive lock to the file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentAcquiresExclusiveLock()
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $content = "Content\n";

        $this->class->put_file_content($file, $content);
        $this->class->put_file_content($file, $content, FALSE, TRUE);

        $this->assertFileEquals(TEST_STATICS . '/Gravity/file1', $file);
    }

    /**
     * Test that put_file_content() appends the content to the file and acquires an exclusive lock.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentAppendsToFileAndAcquiresExclusiveLock()
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $content = "Content\n";

        $this->class->put_file_content($file, $content);
        $this->class->put_file_content($file, $content, TRUE, TRUE);

        $this->assertFileEquals(TEST_STATICS . '/Gravity/file3', $file);
    }

    /**
     * Test getting a SplFileObject for an accessible file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForAccessibleFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $value = $this->class->get_file_object($file);

        $this->assertInstanceOf('\SplFileObject', $value);
    }

    /**
     * Test getting a SplFileObject for an accessible file with invalid mode.
     *
     * @param mixed  $mode    Invalid mode
     * @param String $message Expected error message
     *
     * @dataProvider invalidModesProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForAccessibleFileWithInvalidMode($mode, $message)
    {
        $file = tempnam(sys_get_temp_dir(), 'phpunit_');

        $filename = is_object($mode) ? '' : $file;

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => "SplFileObject::__construct($filename)$message"));

        $value = $this->class->get_file_object($file, $mode);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for an inaccessible file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForInaccessibleFile()
    {
        $file = '/root/ab45cd89';

        $error = "SplFileObject::__construct($file): failed to open stream: Permission denied";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $error));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for a non-existant file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForNonExistantFile()
    {
        $file = sys_get_temp_dir() . '/ab65cd89';

        $error = "SplFileObject::__construct($file): failed to open stream: No such file or directory";

        $this->assertFalse(file_exists($file));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $error));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for a directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectOfDirectory()
    {
        $file = sys_get_temp_dir();

        $error = 'Cannot use SplFileObject with directories';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $error));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for invalid file names.
     *
     * @param mixed  $file    Invalid filename
     * @param String $message Expected error message
     *
     * @dataProvider invalidNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForInvalidFilenames($file, $message)
    {
        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $message));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for boolean file names.
     *
     * @param Boolean $file Boolean filename
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForBooleanFilenames($file)
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

}

?>
