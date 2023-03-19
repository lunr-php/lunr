<?php

/**
 * This file contains the HTMLViewBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Base tests for the view class.
 *
 * @covers     Lunr\Corona\HTMLView
 */
class HTMLViewBaseTest extends HTMLViewTest
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
     * Test that the array of javascript files to include is empty.
     */
    public function testJavascriptEmpty(): void
    {
        $property = $this->get_reflection_property_value('javascript');
        $this->assertArrayEmpty($property);
    }

    /**
     * Test that the array of stylesheet files to include is empty.
     */
    public function testStylesheetEmpty(): void
    {
        $property = $this->get_reflection_property_value('stylesheets');
        $this->assertArrayEmpty($property);
    }

}

?>
