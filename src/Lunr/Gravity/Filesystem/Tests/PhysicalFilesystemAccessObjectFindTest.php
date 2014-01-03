<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectFindTest class.
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
 * This class contains tests for finding files in directories.
 *
 * @category   Filesystem
 * @package    Gravity
 * @subpackage Filesystem
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectFindTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test finding in an accessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectory()
    {
        $expected = [ $this->find_location . '/folder1/filepattern' ];

        $value = $this->class->find_matches('/^.+pattern/i', $this->find_location);

        $this->assertInternalType('array', $value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test finding in an accessible directory with a NULL needle.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithNullNeedle()
    {
        $error = 'RegexIterator::__construct(): Empty regular expression';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $error)
                     );

        $value = $this->class->find_matches(NULL, $this->find_location);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an accessible directory with an object needle.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithObjectNeedle()
    {
        $error = 'RegexIterator::__construct() expects parameter 2 to be string, object given';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', array('message' => $error)
                     );

        $value = $this->class->find_matches(new \stdClass(), $this->find_location);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an accessible directory with an boolean needle.
     *
     * @param Boolean $needle Boolean needle
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithBooleanNeedle($needle)
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->find_matches($needle, $this->find_location);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test finding in an inaccessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfInaccessibleDirectory()
    {
        $directory = '/root';

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: Permission denied";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an non-existant directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfNonExistantDirectory()
    {
        $directory = '/tmp56474q';

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: No such file or directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in a file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetFileMatchesInFile()
    {
        $directory = tempnam('/tmp', 'phpunit_');;

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: Not a directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    Public function testGetMatchesOfNullDirectory()
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('{message}', array('message' => 'Directory name must not be empty.'));

        $value = $this->class->find_matches('/^.+pattern/i', NULL);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test finding in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    Public function testGetMatchesOfObjectDirectory()
    {
        $directory = new \stdClass();

        $error = 'RecursiveDirectoryIterator::__construct() expects parameter 1 to be string, object given';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        array(
                            'message'   => $error,
                            'directory' => $directory
                        )
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an boolean directory.
     *
     * @param Boolean $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    Public function testGetMatchesOfBooleanDirectory($directory)
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->find_matches('/^.+pattern/i', NULL);

        $this->assertArrayEmpty($value);
    }

}

?>
