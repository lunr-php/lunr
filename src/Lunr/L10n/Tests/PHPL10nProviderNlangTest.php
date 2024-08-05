<?php

/**
 * This file contains the PHPL10nProviderNlangTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n\Tests;

/**
 * This class contains the tests for the nlang function.
 *
 * @covers Lunr\L10n\PHPL10nProvider
 */
class PHPL10nProviderNlangTest extends PHPL10nProviderTest
{

    /**
     * Test nlang() without context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContext(): void
    {
        $this->assertEquals('%d Mann', $this->class->nlang('%d man', '%d men', 1));
    }

    /**
     * Test nlang() without context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContext(): void
    {
        $this->assertEquals('%d Männer', $this->class->nlang('%d man', '%d men', 2));
    }

    /**
     * Test nlang() without context returns singular for untranslated singular string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularUntranslatedWithoutContextReturnsSingular(): void
    {
        $this->assertEquals('chair', $this->class->nlang('chair', 'chairs', 1));
    }

    /**
     * Test nlang() without context returns plural for untranslated plural string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralUntranslatedWithoutContextReturnsPlural(): void
    {
        $this->assertEquals('chairs', $this->class->nlang('chair', 'chairs', 2));
    }

    /**
     * Test nlang() with context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContext(): void
    {
        $this->assertEquals('%d Ei', $this->class->nlang('%d egg', '%d eggs', 1, 'food'));
    }

    /**
     * Test nlang() with context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContext(): void
    {
        $this->assertEquals('%d Eier', $this->class->nlang('%d egg', '%d eggs', 2, 'food'));
    }

    /**
     * Test nlang() with context returns singular for untranslated singular string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedSingularWithContextReturnsSingular(): void
    {
        $this->assertEquals('%d chair', $this->class->nlang('%d chair', '%d chairs', 1, 'kitchen'));
    }

    /**
     * Test nlang() with context returns plural for untranslated plural string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedPluralWithContextReturnsPlural(): void
    {
        $this->assertEquals('%d chairs', $this->class->nlang('%d chair', '%d chairs', 2, 'kitchen'));
    }

    /**
     * Test nlang() with superfluous context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithSuperfluousContextReturnsSingular(): void
    {
        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test nlang() with superfluous context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithSuperfluousContextReturnsPlural(): void
    {
        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2, 'people'));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextMissingReturnsSingular(): void
    {
        $this->assertEquals('%d egg', $this->class->nlang('%d egg', '%d eggs', 1));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingReturnsPlural(): void
    {
        $this->assertEquals('%d eggs', $this->class->nlang('%d egg', '%d eggs', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextAndFakePluralTranslatesSingular(): void
    {
        $this->assertEquals('Tisch', $this->class->nlang('table', 'tables', 1));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextAndFakePluralTranslatesSingular(): void
    {
        $this->assertEquals('Tisch', $this->class->nlang('table', 'tables', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingAndFakePluralReturnsPlural(): void
    {
        $this->assertEquals('banks', $this->class->nlang('bank', 'banks', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextAndFakePluralTranslatesSingular(): void
    {
        $this->assertEquals('Bank', $this->class->nlang('bank', 'banks', 1, 'finance'));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextAndFakePluralTranslatesSingular(): void
    {
        $this->assertEquals('Bank', $this->class->nlang('bank', 'banks', 2, 'finance'));
    }

}

?>
