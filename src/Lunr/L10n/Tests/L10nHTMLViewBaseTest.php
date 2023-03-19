<?php

/**
 * This file contains the L10nHTMLViewBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nHTMLView;

/**
 * Base tests for the localized view class.
 *
 * @covers Lunr\L10n\L10nHTMLView
 */
class L10nHTMLViewBaseTest extends L10nHTMLViewTest
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly(): void
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the l10nprovider class is set correctly.
     */
    public function testL10nProviderSetCorrectly()
    {
        $this->assertPropertySame('l10n', $this->l10nprovider);
    }

}

?>
