<?php

/**
 * This file contains the WebRequestParserParseFilesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseFilesTest extends WebRequestParserTestCase
{

    /**
     * Test storing invalid super global values.
     *
     * @param mixed $files Invalid super global values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\WebRequestParser::parse_files
     */
    public function testParseInvalidFilesValuesReturnsEmptyArray($files): void
    {
        $_FILES = $files;

        $result = $this->class->parse_files();

        $this->assertArrayEmpty($result);
    }

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $files Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_files
    */
    public function testParseInvalidFilesValuesResetsFiles($files): void
    {
        $_FILES = $files;

        $this->class->parse_files();

        $this->assertArrayEmpty($_FILES);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_files
     */
    public function testParseValidFilesValues(): void
    {
        $_FILES['test1'] = [
            'name'     => 'Name',
            'type'     => 'Type',
            'tmp_name' => 'Tmp',
            'error'    => 'Error',
            'size'     => 'Size',
        ];

        $_FILES['test2'] = [
            'name'     => 'Name2',
            'type'     => 'Type2',
            'tmp_name' => 'Tmp2',
            'error'    => 'Error2',
            'size'     => 'Size2',
        ];

        $cache = $_FILES;

        $result = $this->class->parse_files();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_files
     */
    public function testFilesEmptyAfterParse(): void
    {
        $_FILES['test1'] = [
            'name'     => 'Name',
            'type'     => 'Type',
            'tmp_name' => 'Tmp',
            'error'    => 'Error',
            'size'     => 'Size',
        ];

        $_FILES['test2'] = [
            'name'     => 'Name2',
            'type'     => 'Type2',
            'tmp_name' => 'Tmp2',
            'error'    => 'Error2',
            'size'     => 'Size2',
        ];

        $this->class->parse_files();

        $this->assertArrayEmpty($_FILES);
    }

}

?>
