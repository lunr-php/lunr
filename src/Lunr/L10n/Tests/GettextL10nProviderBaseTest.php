<?php

/**
 * This file contains the GettextL10nProviderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\L10n\GettextL10nProvider;

/**
 * This class contains the tests for the contructor and init function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\GettextL10nProvider
 */
class GettextL10nProviderBaseTest extends GettextL10nProviderTest
{

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly()
    {
        $property = $this->provider_reflection->getProperty('configuration');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);

        $this->assertInstanceOf('Lunr\Core\Configuration', $value);
        $this->assertSame($this->configuration, $value);
    }

    /**
     * Test that the Logger class is passed correctly.
     */
    public function testLoggerIsPassedCorrectly()
    {
        $property = $this->provider_reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that init() works correctly.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\L10n\GettextL10nProvider::init
     */
    public function testInit()
    {
        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array(self::LANGUAGE));

        $this->assertEquals(self::LANGUAGE, setlocale(LC_MESSAGES, 0));
        $this->assertEquals($this->configuration['l10n']['domain'], textdomain(NULL));
    }

}

?>
