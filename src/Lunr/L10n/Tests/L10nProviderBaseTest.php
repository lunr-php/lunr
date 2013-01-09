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

    /**
     * Test that setting a valid default language stores it in the object.
     *
     * @covers Lunr\L10n\L10nProvider::set_default_language
     */
    public function testSetValidDefaultLanguage()
    {
        $property = $this->provider_reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->provider->set_default_language(self::LANGUAGE);

        $this->assertEquals(self::LANGUAGE, $property->getValue($this->provider));
    }

    /**
     * Test that setting an invalid default language doesn't store it in the object.
     *
     * @covers Lunr\L10n\L10nProvider::set_default_language
     */
    public function testSetInvalidDefaultLanguage()
    {
        $property = $this->provider_reflection->getProperty('default_language');
        $property->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->provider->set_default_language('Whatever');

        $this->assertEquals('en_US', $property->getValue($this->provider));
    }

    /**
     * Test that setting a valid default language doesn't alter the currently set locale.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\L10n\L10nProvider::set_default_language
     */
    public function testSetValidDefaultLanguageDoesNotAlterCurrentLocale()
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->provider->set_default_language(self::LANGUAGE);

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting an invalid default language doesn't alter the currently set locale.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\L10n\L10nProvider::set_default_language
     */
    public function testSetInvalidDefaultLanguageDoesNotAlterCurrentLocale()
    {
        $current = setlocale(LC_MESSAGES, 0);

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->provider->set_default_language('Whatever');

        $this->assertEquals($current, setlocale(LC_MESSAGES, 0));
    }

    /**
     * Test that setting a valid locales location stores it in the object.
     *
     * @covers Lunr\L10n\L10nProvider::set_locales_location
     */
    public function testSetValidLocalesLocation()
    {
        $property = $this->provider_reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        $location = dirname(__FILE__) . '/../../../../tests/statics/l10n';

        $this->provider->set_locales_location($location);

        $this->assertEquals($location, $property->getValue($this->provider));
    }

    /**
     * Test that setting an invalid locales location doesn't store it in the object.
     *
     * @covers Lunr\L10n\L10nProvider::set_locales_location
     */
    public function testSetInvalidLocalesLocation()
    {
        $property = $this->provider_reflection->getProperty('locales_location');
        $property->setAccessible(TRUE);

        $location         = dirname(__FILE__) . '/../../../tests/statics/l10n';
        $default_location = dirname($_SERVER['PHP_SELF']) . '/l10n';

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->provider->set_locales_location($location);

        $this->assertEquals($default_location, $property->getValue($this->provider));
    }

}

?>
