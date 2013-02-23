<?php

/**
 * This file contains the L10nProviderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

/**
 * This class contains test methods for the abstract L10nProvider class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10nProvider
 */
class L10nProviderBaseTest extends L10nProviderTest
{

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLanguageIsSetCorrectly()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);

        $this->assertEquals(self::LANGUAGE, $property->getValue($this->provider));
    }

    /**
     * Test that the domain is correctly stored in the object.
     */
    public function testDomainIsSetCorrectly()
    {
        $property = $this->provider_reflection->getProperty('domain');
        $property->setAccessible(TRUE);

        $this->assertEquals(self::DOMAIN, $property->getValue($this->provider));
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testDefaultLanguageSetCorrectly()
    {
        $property = $this->provider_reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->assertEquals('en_US', $property->getValue($this->provider));
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLocaleLocationSetCorrectly()
    {
        $property = $this->provider_reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        // /usr/bin/l10n by default
        $default_location = dirname($_SERVER['PHP_SELF']) . '/l10n';

        $this->assertEquals($default_location, $property->getValue($this->provider));
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
     * Test that get_language() returns the set language.
     *
     * @covers Lunr\L10n\L10nProvider::get_language
     */
    public function testGetLanguageReturnsLanguage()
    {
        $this->assertEquals(self::LANGUAGE, $this->provider->get_language());
    }

}

?>
