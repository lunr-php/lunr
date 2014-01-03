<?php

/**
 * This file contains the HTMLViewBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Base tests for the view class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\HTMLView
 */
class HTMLViewBaseTest extends HTMLViewTest
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

    /**
     * Test that the array of javascript files to include is empty.
     */
    public function testJavascriptEmpty()
    {
        $property = $this->get_reflection_property_value('javascript');
        $this->assertArrayEmpty($property);
    }

    /**
     * Test that the array of stylesheet files to include is empty.
     */
    public function testStylesheetEmpty()
    {
        $property = $this->get_reflection_property_value('stylesheets');
        $this->assertArrayEmpty($property);
    }

}

?>
