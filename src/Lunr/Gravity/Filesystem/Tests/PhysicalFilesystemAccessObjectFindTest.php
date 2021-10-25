<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectFindTest class.
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
 * This class contains tests for finding files in directories.
 *
 * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectFindTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test finding in an accessible directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectory(): void
    {
        $expected = [ $this->find_location . '/folder1/filepattern' ];

        $value = $this->class->find_matches('/^.+pattern/i', $this->find_location);

        $this->assertIsArray($value);

        sort($value);

        $this->assertEquals($expected, $value);
    }

    /**
     * Test finding in an accessible directory with a NULL needle.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithNullNeedle(): void
    {
        $error = 'RegexIterator::__construct(): Empty regular expression';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', [ 'message' => $error ]
                     );

        $value = $this->class->find_matches(NULL, $this->find_location);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an accessible directory with an object needle.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithObjectNeedle(): void
    {
        $error = 'RegexIterator::__construct() expects parameter 2 to be string, object given';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{message}', [ 'message' => $error ]
                     );

        $value = $this->class->find_matches(new \stdClass(), $this->find_location);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an accessible directory with an boolean needle.
     *
     * @param bool $needle Boolean needle
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfAccessibleDirectoryWithBooleanNeedle($needle): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->find_matches($needle, $this->find_location);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test finding in an inaccessible directory.
     *
     * @requires OS Linux
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfInaccessibleDirectory(): void
    {
        $directory = '/root';

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: Permission denied";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an non-existant directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfNonExistantDirectory(): void
    {
        $directory = '/tmp56474q';

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: No such file or directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in a file.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetFileMatchesInFile(): void
    {
        $directory = tempnam('/tmp', 'phpunit_');;

        $error = "RecursiveDirectoryIterator::__construct($directory): failed to open dir: Not a directory";

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);

        unlink($directory);
    }

    /**
     * Test finding in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfNullDirectory(): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('{message}', [ 'message' => 'Directory name must not be empty.' ]);

        $value = $this->class->find_matches('/^.+pattern/i', NULL);

        $this->assertArrayEmpty($value);
    }

    /**
     * Test finding in an invalid directory.
     *
     * @covers Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfObjectDirectory(): void
    {
        $directory = new \stdClass();

        $error = 'RecursiveDirectoryIterator::__construct() expects parameter 1 to be a valid path, object given';

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with("Couldn't open directory '{directory}': {message}",
                        [
                            'message'   => $error,
                            'directory' => $directory,
                        ]
                     );

        $value = $this->class->find_matches('/^.+pattern/i', $directory);

        $this->assertFalse($value);
    }

    /**
     * Test finding in an boolean directory.
     *
     * @param bool $directory Boolean directory value
     *
     * @dataProvider booleanNameProvider
     * @covers       Lunr\Gravity\Filesystem\PhysicalFilesystemAccessObject::find_matches
     */
    public function testGetMatchesOfBooleanDirectory($directory): void
    {
        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->find_matches('/^.+pattern/i', NULL);

        $this->assertArrayEmpty($value);
    }

}

?>
