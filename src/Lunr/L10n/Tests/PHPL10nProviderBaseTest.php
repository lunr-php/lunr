<?php

/**
 * This file contains the PHPL10nProviderBaseTest class.
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

use Lunr\L10n\PHPL10nProvider;

/**
 * This class contains the tests for the contructor and init function,
 * as well as the tests for lang() and nlang() with the default language.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\PHPL10nProvider
 */
class PHPL10nProviderBaseTest extends PHPL10nProviderTest
{

    /**
     * Test that the lang_array attribute is empty by default.
     */
    public function testLangArrayIsEmptyByDefault()
    {
        $property = $this->provider_reflection->getProperty('lang_array');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the lang_array is not initialized by default.
     */
    public function testInitializedIsFalseByDefault()
    {
        $property = $this->provider_reflection->getProperty('initialized');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->provider));
    }

    /**
     * Test that init() sets initialized to TRUE.
     *
     * @runInSeparateProcess
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitSetsInitializedTrue()
    {
        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array(self::LANGUAGE));

        $property = $this->provider_reflection->getProperty('initialized');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->provider));
    }

    /**
     * Test that init() populates the lang_array for a non-default language.
     *
     * @runInSeparateProcess
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForNonDefaultLanguageSetsLangArray()
    {
        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array(self::LANGUAGE));

        $property = $this->provider_reflection->getProperty('lang_array');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertNotEmpty($value);
    }

    /**
     * Test that init() does not populate the lang_array with the default language.
     *
     * @runInSeparateProcess
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForDefaultLanguageDoesNotSetLangArray()
    {
        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array('en_US'));

        $property = $this->provider_reflection->getProperty('lang_array');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that init() does not re-populate the lang_array if already initialized.
     *
     * @runInSeparateProcess
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForDefaultLanguageDoesNotRepopulate()
    {
        $property = $this->provider_reflection->getProperty('lang_array');
        $property->setAccessible(TRUE);

        $method = $this->provider_reflection->getMethod('init');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->provider, array(self::LANGUAGE));

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertNotEmpty($value);

        $method->invokeArgs($this->provider, array('en_US'));

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertNotEmpty($value);
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithoutContextReturnsIdentifierWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('table', $this->provider->lang('table'));
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContextReturnsIdentifierWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('table', $this->provider->lang('table', 'kitchen'));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testNlangSingularWithoutContextReturnsSingularWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testNlangPluralWithoutContextReturnsPluralWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testNlangSingularWithContextReturnsSingularWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testNlangPluralWithContextReturnsPluralWhenLanguageIsDefault()
    {
        $property = $this->provider_reflection->getProperty('language');
        $property->setAccessible(TRUE);
        $property->setValue($this->provider, 'en_US');

        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2, 'people'));
    }

}

?>
