<?php

/**
 * This file contains the CliRequestParserBaseTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserBaseTest extends CliRequestParserTest
{

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly(): void
    {
        $this->assertPropertySame('config', $this->configuration);
    }

    /**
     * Test that $ast is fetched correctly.
     */
    public function testAstIsFetchedCorrectly(): void
    {
        $ast = $this->get_reflection_property_value('ast');

        $this->assertArrayNotEmpty($ast);
        $this->assertCount(6, $ast);
    }

}

?>
