<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectFileTest class.
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
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectFileTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that get_file_content() gets contents of an accessible file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithAccessibleFile()
    {
        $file = __DIR__ . '/../../../../tests/statics/logs/error.log';

        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $fetched = $this->class->get_file_content($file);

        $this->assertEquals($content, $fetched);
    }

    /**
     * Test that get_file_content() does not get contents of an inaccessible file.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithInaccessibleFile()
    {
        $file = '/root/ab45cd89';

        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() does not get contents of a non-existant file.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithNonExistantFile()
    {
        $file = '/tmp/ab45cd89';

        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() does not get contents of a directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentOfDirectory()
    {
        $file = '/tmp';

        $fetched = $this->class->get_file_content($file);

        $this->assertEquals('', $fetched);
    }

    /**
     * Test that get_file_content() with invalid file names.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      invalidNameProvider
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithInvalidFilenames($file)
    {
        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that get_file_content() with invalid file names.
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_content
     */
    public function testGetFileContentWithBooleanFilenames($file)
    {
        $fetched = $this->class->get_file_content($file);

        $this->assertFalse($fetched);
    }

    /**
     * Test that put_file_content() puts contents in an accessible file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithAccessibleFile()
    {
        $file = tempnam('/tmp', 'phpunit_');

        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFileEquals(__DIR__ . '/../../../../tests/statics/logs/error.log', $file);
        $this->assertEquals(35, $written);
    }

    /**
     * Test that put_file_content() does not put contents in an inaccessible file.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithInaccessibleFile()
    {
        $file = '/root/ab45cd89';

        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() puts contents in a non-existant file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithNonExistantFile()
    {
        $file = '/tmp/ab65cd89';

        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFileEquals(__DIR__ . '/../../../../tests/statics/logs/error.log', $file);
        $this->assertEquals(35, $written);
    }

    /**
     * Test that put_file_content() does not put contents in a directory.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentInDirectory()
    {
        $file = '/tmp';

        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() with invalid file names.
     *
     * @expectedException PHPUnit_Framework_Error_Warning
     * @dataProvider      invalidNameProvider
     * @covers            Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithInvalidFilenames($file)
    {
        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test that put_file_content() with boolean file names.
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::put_file_content
     */
    public function testPutFileContentWithBooleanFilenames($file)
    {
        $content = "[2011-11-10 10:30:22]: WARNING: Foo";

        $written = $this->class->put_file_content($file, $content);

        $this->assertFalse($written);
    }

    /**
     * Test getting a SplFileObject for an accessible file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForAccessibleFile()
    {
        $file = tempnam('/tmp', 'phpunit_');

        $value = $this->class->get_file_object($file);

        $this->assertInstanceOf('\SplFileObject', $value);
    }

    /**
     * Test getting a SplFileObject for an accessible file with invalid mode.
     *
     * @runInSeparateProcess
     *
     * @dataProvider invalidModesProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForAccessibleFileWithInvalidMode($mode, $message)
    {
        $file = tempnam('/tmp', 'phpunit_');

        $filename = is_object($mode) ? '' : $file;

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("{message}", array('message' => "SplFileObject::__construct($filename)$message"));

        $value = $this->class->get_file_object($file, $mode);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for an inaccessible file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForInaccessibleFile()
    {
        $file = '/root/ab45cd89';

        $error = "SplFileObject::__construct($file): failed to open stream: Permission denied";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("{message}", array('message' => $error));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for a non-existant file.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForNonExistantFile()
    {
        $file = '/tmp/ab65cd89';

        $value = $this->class->get_file_object($file);

        $this->assertInstanceOf('\SplFileObject', $value);
    }

    /**
     * Test getting a SplFileObject for a directory.
     *
     * @covers Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectOfDirectory()
    {
        $file = '/tmp';

        $error = "Cannot use SplFileObject with directories";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("{message}", array('message' => $error));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for invalid file names.
     *
     * @dataProvider invalidNameProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
     */
    public function testGetFileObjectForInvalidFilenames($file, $message)
    {
        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("{message}", array('message' => $message));

        $value = $this->class->get_file_object($file);

        $this->assertFalse($value);
    }

    /**
     * Test getting a SplFileObject for boolean file names.
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\DataAccess\PhysicalFilesystemAccessObject::get_file_object
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
