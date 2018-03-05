<?php

/**
 * This file contains the WebRequestParserParseServerTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseServerTest extends WebRequestParserTest
{

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the super global is not reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $server Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_server
    */
    public function testParseInvalidServerValuesIntactServer($server)
    {
        $backup = $_SERVER;

        $_SERVER = $server;

        $this->class->parse_server();

        $this->assertEquals($_SERVER, $server);

        $_SERVER = $backup;
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_server
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
     * @covers Lunr\Corona\WebRequestParser::parse_server
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
