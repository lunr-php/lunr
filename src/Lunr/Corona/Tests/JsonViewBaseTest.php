<?php

/**
 * This file contains the JsonViewBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the JsonView class.
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\JsonView
 */
class JsonViewBaseTest extends JsonViewTest
{

    /**
     * Test that the Request class is passed correctly.
     */
    public function testRequestIsPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class is passed correctly.
     */
    public function testResponseIsPassedCorrectly()
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly()
    {
        $this->assertPropertySame('configuration', $this->configuration);
    }

}

?>
