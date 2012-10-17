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

namespace Lunr\Libraries\L10n;

/**
 * This class contains the tests for the contructor and init function,
 * as well as the tests for lang() and nlang() with the default language.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\PHPL10nProvider
 */
class PHPL10nProviderBaseTest extends PHPL10nProviderTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpPlain();
    }

    /**
     * Test that the lang_array attribute is empty when the class is initialized with the default language.
     */
    public function testLangArrayEmptyForDefaultLanguage()
    {
        $property = $this->provider_reflection->getProperty('lang_array');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->provider);
        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that init() works correctly.
     *
     * @runInSeparateProcess
     *
     * @depends testLangArrayEmptyForDefaultLanguage
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::init
     */
    public function testInit()
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
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testLangWithoutContextReturnsIdentifierWhenLanguageIsDefault()
    {
        $this->assertEquals('table', $this->provider->lang('table'));
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContextReturnsIdentifierWhenLanguageIsDefault()
    {
        $this->assertEquals('table', $this->provider->lang('table', 'kitchen'));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testNlangSingularWithoutContextReturnsSingularWhenLanguageIsDefault()
    {
        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testNlangPluralWithoutContextReturnsPluralWhenLanguageIsDefault()
    {
        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testNlangSingularWithContextReturnsSingularWhenLanguageIsDefault()
    {
        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function testNlangPluralWithContextReturnsPluralWhenLanguageIsDefault()
    {
        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2, 'people'));
    }

}

?>
