<?php

/**
 * This file contains the WebRequestParserBaseTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserBaseTest extends WebRequestParserTest
{

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly(): void
    {
        $this->assertPropertySame('config', $this->configuration);
    }

    /**
     * Test that the header class is set correctly.
     */
    public function testHeaderSetCorrectly(): void
    {
        $this->assertPropertySame('header', $this->header);
    }

    /**
     * Test that $request_parsed is FALSE by default.
     */
    public function testRequestParsedIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('request_parsed'));
    }

}

?>
