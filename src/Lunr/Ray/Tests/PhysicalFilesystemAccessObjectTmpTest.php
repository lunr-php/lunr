<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectTmpTest class.
 *
 * @package    Lunr\Ray
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for file related methods in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectTmpTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that get_tmp_file() returns a file from tempnam.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_tmp_file
     */
    public function testGetTmpFileSucceedsWithoutPrefix(): void
    {
        $fetched = $this->class->get_tmp_file();

        $this->assertFileExists($fetched);
    }

    /**
     * Test that get_tmp_file() returns a file from tempnam with the provided prefix.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::get_tmp_file
     */
    public function testGetTmpFileSucceedsWithPrefix(): void
    {
        $fetched = $this->class->get_tmp_file('prefix');

        if (method_exists($this, 'assertMatchesRegularExpression'))
        {
            $this->assertMatchesRegularExpression('/prefix/', $fetched);
        }
        else
        {
            $this->assertRegExp('/prefix/', $fetched);
        }

        $this->assertFileExists($fetched);
    }

}

?>