<?php

/**
 * This file contains the L10nHTMLViewBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\L10nHTMLView;

/**
 * Base tests for the localized view class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nHTMLView
 */
class L10nHTMLViewBaseTest extends L10nHTMLViewTest
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
