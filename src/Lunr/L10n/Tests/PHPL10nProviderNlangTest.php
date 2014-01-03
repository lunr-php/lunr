<?php

/**
 * This file contains the PHPL10nProviderNlangTest class.
 *
 * PHP Version 5.3
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
 * This class contains the tests for the nlang function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\PHPL10nProvider
 */
class PHPL10nProviderNlangTest extends PHPL10nProviderTest
{

    /**
     * Test nlang() without context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContext()
    {
        $this->assertEquals('%d Mann', $this->class->nlang('%d man', '%d men', 1));
    }

    /**
     * Test nlang() without context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContext()
    {
        $this->assertEquals('%d Männer', $this->class->nlang('%d man', '%d men', 2));
    }

    /**
     * Test nlang() without context returns singular for untranslated singular string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularUntranslatedWithoutContextReturnsSingular()
    {
        $this->assertEquals('chair', $this->class->nlang('chair', 'chairs', 1));
    }

    /**
     * Test nlang() without context returns plural for untranslated plural string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralUntranslatedWithoutContextReturnsPlural()
    {
        $this->assertEquals('chairs', $this->class->nlang('chair', 'chairs', 2));
    }

    /**
     * Test nlang() with context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContext()
    {
        $this->assertEquals('%d Ei', $this->class->nlang('%d egg', '%d eggs', 1, 'food'));
    }

    /**
     * Test nlang() with context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContext()
    {
        $this->assertEquals('%d Eier', $this->class->nlang('%d egg', '%d eggs', 2, 'food'));
    }

    /**
     * Test nlang() with context returns singular for untranslated singular string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedSingularWithContextReturnsSingular()
    {
        $this->assertEquals('%d chair', $this->class->nlang('%d chair', '%d chairs', 1, 'kitchen'));
    }

    /**
     * Test nlang() with context returns plural for untranslated plural string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedPluralWithContextReturnsPlural()
    {
        $this->assertEquals('%d chairs', $this->class->nlang('%d chair', '%d chairs', 2, 'kitchen'));
    }

    /**
     * Test nlang() with superfluous context and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithSuperfluousContextReturnsSingular()
    {
        $this->assertEquals('%d man', $this->class->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test nlang() with superfluous context and plural value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithSuperfluousContextReturnsPlural()
    {
        $this->assertEquals('%d men', $this->class->nlang('%d man', '%d men', 2, 'people'));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextMissingReturnsSingular()
    {
        $this->assertEquals('%d egg', $this->class->nlang('%d egg', '%d eggs', 1));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingReturnsPlural()
    {
        $this->assertEquals('%d eggs', $this->class->nlang('%d egg', '%d eggs', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->class->nlang('table', 'tables', 1));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->class->nlang('table', 'tables', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingAndFakePluralReturnsPlural()
    {
        $this->assertEquals('banks', $this->class->nlang('bank', 'banks', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->class->nlang('bank', 'banks', 1, 'finance'));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->class->nlang('bank', 'banks', 2, 'finance'));
    }

}

?>
