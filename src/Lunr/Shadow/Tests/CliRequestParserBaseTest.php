<?php

/**
 * This file contains the CliRequestParserBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserBaseTest extends CliRequestParserTestCase
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
        $ast = $this->getReflectionPropertyValue('ast');

        $this->assertArrayNotEmpty($ast);
        $this->assertCount(6, $ast);
    }

}

?>
