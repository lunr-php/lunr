<?php

/**
 * This file contains the WebRequestParserBaseTest class.
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
class WebRequestParserBaseTest extends WebRequestParserTestCase
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
        $this->assertFalse($this->getReflectionPropertyValue('requestParsed'));
    }

}

?>
