<?php

/**
 * This file contains the ViewL10nTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * Base tests for the view class when there is a L10nProvider.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\View
 */
class ViewL10nTest extends ViewTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->setUpL10n();
    }

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

    /**
     * Test that the l10nprovider class is set correctly.
     */
    public function testL10nProviderSetCorrectly()
    {
        $property = $this->view_reflection->getProperty('l10n');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->l10nprovider, $property->getValue($this->view));
        $this->assertSame($this->l10nprovider, $property->getValue($this->view));
    }

}

?>
