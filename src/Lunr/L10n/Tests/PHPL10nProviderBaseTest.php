<?php

/**
 * This file contains the PHPL10nProviderBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

/**
 * This class contains the tests for the constructor and init function,
 * as well as the tests for lang() and nlang() with the default language.
 *
 * @covers Lunr\L10n\PHPL10nProvider
 */
class PHPL10nProviderBaseTest extends PHPL10nProviderTest
{

    /**
     * Test that the lang_array attribute is empty by default.
     */
    public function testLangArrayIsEmptyByDefault(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('lang_array'));
    }

    /**
     * Test that the lang_array is not initialized by default.
     */
    public function testInitializedIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('initialized'));
    }

    /**
     * Test that init() sets initialized to TRUE.
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitSetsInitializedTrue(): void
    {
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [ self::LANGUAGE ]);

        $this->assertTrue($this->get_reflection_property_value('initialized'));
    }

    /**
     * Test that init() populates the lang_array for a non-default language.
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForNonDefaultLanguageSetsLangArray(): void
    {
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [ self::LANGUAGE ]);

        $property = $this->get_reflection_property_value('lang_array');

        $this->assertIsArray($property);
        $this->assertNotEmpty($property);
    }

    /**
     * Test that init() does not populate the lang_array with the default language.
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForDefaultLanguageDoesNotSetLangArray(): void
    {
        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [ 'en_US' ]);

        $this->assertArrayEmpty($this->get_reflection_property_value('lang_array'));
    }

    /**
     * Test that init() does not re-populate the lang_array if already initialized.
     *
     * @depends testLangArrayIsEmptyByDefault
     * @covers  Lunr\L10n\PHPL10nProvider::init
     */
    public function testInitForDefaultLanguageDoesNotRepopulate(): void
    {
        $property = $this->get_accessible_reflection_property('lang_array');

        $method = $this->get_accessible_reflection_method('init');

        $method->invokeArgs($this->class, [ self::LANGUAGE ]);

        $value = $property->getValue($this->class);
        $this->assertIsArray($value);
        $this->assertNotEmpty($value);

        $method->invokeArgs($this->class, [ 'en_US' ]);

        $value = $property->getValue($this->class);
        $this->assertIsArray($value);
        $this->assertNotEmpty($value);
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithoutContextReturnsIdentifierWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('table', $this->class->lang('table'));
    }

    /**
     * Test that the lang() function returns the identifier when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContextReturnsIdentifierWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('table', $this->class->lang('table', 'kitchen'));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextReturnsSingularWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextReturnsPluralWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2));
    }

    /**
     * Test that the nlang() function returns singular when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextReturnsSingularWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test that the nlang() function returns plural when the set language is the default language.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextReturnsPluralWhenLanguageIsDefault(): void
    {
        $this->set_reflection_property_value('language', 'en_US');

        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2, 'people'));
    }

}

?>
