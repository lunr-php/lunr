<?php

/**
 * This file contains the PHPL10nProviderBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
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
        $this->assertArrayEmpty($this->get_reflection_property_value('lang_array'));
    }

    /**
     * Test that the lang_array is not initialized by default.
     */
    public function testInitializedIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('initialized'));
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
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, array(self::LANGUAGE));

        $this->assertTrue($this->get_reflection_property_value('initialized'));
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
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, array(self::LANGUAGE));

        $property = $this->get_reflection_property_value('lang_array');

        $this->assertInternalType('array', $property);
        $this->assertNotEmpty($property);
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
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, array('en_US'));

        $this->assertArrayEmpty($this->get_reflection_property_value('lang_array'));
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
        $property = $this->get_accessible_reflection_property('lang_array');

        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, array(self::LANGUAGE));

        $value = $property->getValue($this->class);
        $this->assertInternalType('array', $value);
        $this->assertNotEmpty($value);

        $method->invokeArgs($this->class, array('en_US'));

        $value = $property->getValue($this->class);
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
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('table', $this->class->lang('table'));
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContextReturnsIdentifierWhenLanguageIsDefault()
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('table', $this->class->lang('table', 'kitchen'));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextReturnsSingularWhenLanguageIsDefault()
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextReturnsPluralWhenLanguageIsDefault()
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextReturnsSingularWhenLanguageIsDefault()
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextReturnsPluralWhenLanguageIsDefault()
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2, 'people'));
    }

}

?>
