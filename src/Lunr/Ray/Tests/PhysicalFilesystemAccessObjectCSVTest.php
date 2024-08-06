<?php

/**
 * This file contains the PhysicalFilesystemAccessObjectCSVTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ray\Tests;

/**
 * This class contains tests for the put_csv_file_content method in the PhysicalFilesystemAccessObject.
 *
 * @covers Lunr\Ray\PhysicalFilesystemAccessObject
 */
class PhysicalFilesystemAccessObjectCSVTest extends PhysicalFilesystemAccessObjectTest
{

    /**
     * Test that put_csv_file_content() logs a warning when cannot open the given file.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentCannotOpenFile(): void
    {
        $this->mock_function('fopen', function () { return FALSE; });

        $this->logger->expects($this->once())
             ->method('warning')
             ->with($this->equalTo('Could not open the file: filepath'));

        $this->assertFalse($this->class->put_csv_file_content('filepath', [ [ 'value1', 'value2' ] ]));

        $this->unmock_function('fopen');
    }

    /**
     * Test that put_csv_file_content() creates an empty file in invalid array values.
     *
     * @param mixed $values Invalid values
     *
     * @dataProvider invalidCSVArrayValuesProvider
     * @covers       Lunr\Ray\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentInInvalidArrayValues($values): void
    {
        $filepath = TEST_STATICS . '/Ray/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ $values ] ]));
        $this->assertStringMatchesFormatFile($filepath, "\n");

        unlink($filepath);
    }

    /**
     * Test that put_csv_file_content() returns TRUE in success.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentSuccess(): void
    {
        $filepath = TEST_STATICS . '/Ray/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ 'value1', 'value2' ] ]));
        $this->assertStringMatchesFormatFile($filepath, "value1,value2\n");

        unlink($filepath);
    }

    /**
     * Test that put_csv_file_content() returns TRUE in success with enclosure and delimiter.
     *
     * @covers Lunr\Ray\PhysicalFilesystemAccessObject::put_csv_file_content
     */
    public function testPutCSVFileContentSuccessCustomDelimiter(): void
    {
        $filepath = TEST_STATICS . '/Ray/folder2/test.csv';

        $this->assertTrue($this->class->put_csv_file_content($filepath, [ [ 'value1', 'value2' ] ], '-'));
        $this->assertStringMatchesFormatFile($filepath, "value1-value2\n");

        unlink($filepath);
    }

}

?>
