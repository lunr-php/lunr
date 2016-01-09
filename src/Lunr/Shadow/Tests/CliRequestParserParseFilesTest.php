<?php

/**
 * This file contains the CliRequestParserParseFilesTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseFilesTest extends CliRequestParserTest
{

    /**
     * Test storing empty super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_files
     */
    public function testParseEmptySuperGlobalValues()
    {
        $result = $this->class->parse_files();

        $this->assertArrayEmpty($result);
    }

}

?>
