<?php

/**
 * This file contains the CliRequestParserParseServerTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseServerTest extends CliRequestParserTest
{

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_server
     */
    public function testParseValidServerValues()
    {
        $_SERVER['test1'] = 'value1';
        $_SERVER['test2'] = 'value2';
        $cache            = $_SERVER;

        $result = $this->class->parse_server();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is intact after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_server
     */
    public function testServerIntactAfterParse()
    {
        $_SERVER['test1'] = 'value1';
        $_SERVER['test2'] = 'value2';

        $server = $_SERVER;

        $this->class->parse_server();

        $this->assertEquals($_SERVER, $server);
    }

}

?>
