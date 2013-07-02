<?php

/**
 * This file contains the ViewBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Base tests for the view class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\View
 */
class ViewBaseTest extends ViewTest
{

    /**
     * Test that the request class is set correctly.
     */
    public function testRequestSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('request');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->request, $property->getValue($this->view));
        $this->assertSame($this->request, $property->getValue($this->view));
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('response');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->response, $property->getValue($this->view));
        $this->assertSame($this->response, $property->getValue($this->view));
    }

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('configuration');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->configuration, $property->getValue($this->view));
        $this->assertSame($this->configuration, $property->getValue($this->view));
    }

}

?>
