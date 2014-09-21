<?php

/**
 * This file contains the WebRequestParserBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserBaseTest extends WebRequestParserTest
{

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $this->assertPropertySame('config', $this->configuration);
    }

    /**
     * Test that the header class is set correctly.
     */
    public function testHeaderSetCorrectly()
    {
        $this->assertPropertySame('header', $this->header);
    }

    /**
     * Test that $request_parsed is FALSE by default.
     */
    public function testRequestParsedIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('request_parsed'));
    }

}

?>
