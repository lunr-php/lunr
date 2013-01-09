<?php

/**
 * This file contains the PHPL10nProviderLangTest class.
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

use Lunr\L10n\PHPL10nProvider;

/**
 * This class contains the tests for the lang function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\PHPL10nProvider
 */
class PHPL10nProviderLangTest extends PHPL10nProviderTest
{

    /**
     * Test lang() without context.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithoutContext()
    {
        $this->assertEquals('Tisch', $this->provider->lang('table'));
    }

    /**
     * Test lang() without context returns identifier for untranslated string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangUntranslatedWithoutContextReturnsIdentifier()
    {
        $this->assertEquals('chair', $this->provider->lang('chair'));
    }

    /**
     * Test lang() with context.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContext()
    {
        $this->assertEquals('Bank', $this->provider->lang('bank', 'finance'));
    }

    /**
     * Test lang() with context returns identifier for untranslated string.
     *
     * @covers Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangUntranslatedWithContextReturnsIdentifier()
    {
        $this->assertEquals('chair', $this->provider->lang('chair', 'kitchen'));
    }

    /**
     * Test lang() with superfluous context.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithSuperfluousContextReturnsIdentifier()
    {
        $this->assertEquals('table', $this->provider->lang('table', 'kitchen'));
    }

    /**
     * Test lang() with context missing.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangWithContextMissingReturnsIdentifier()
    {
        $this->assertEquals('bank', $this->provider->lang('bank'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangAccessingPluralWithSingularTranslatesSingular()
    {
        $this->assertEquals('%d Mann', $this->provider->lang('%d man'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangAccessingPluralWithPluralReturnsIdentifier()
    {
        $this->assertEquals('%d men', $this->provider->lang('%d men'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangAccessingPluralWithSingularAndContextTranslatesSingular()
    {
        $this->assertEquals('%d Ei', $this->provider->lang('%d egg', 'food'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @depends Lunr\L10n\Tests\PHPL10nProviderBaseTest::testInitForNonDefaultLanguageSetsLangArray
     * @covers  Lunr\L10n\PHPL10nProvider::lang
     */
    public function testLangAccessingPluralWithPluralAndContextReturnsIdentifier()
    {
        $this->assertEquals('%d eggs', $this->provider->lang('%d eggs', 'food'));
    }

}

?>
