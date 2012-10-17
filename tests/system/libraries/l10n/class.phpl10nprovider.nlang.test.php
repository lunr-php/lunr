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
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\L10n;

/**
 * This class contains the tests for the nlang function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\PHPL10nProvider
 */
class PHPL10nProviderNlangTest extends PHPL10nProviderTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpFull();
    }

    /**
     * Test nlang() without context and singular value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContext()
    {
        $this->assertEquals('%d Mann', $this->provider->nlang('%d man', '%d men', 1));
    }

    /**
     * Test nlang() without context and plural value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContext()
    {
        $this->assertEquals('%d Männer', $this->provider->nlang('%d man', '%d men', 2));
    }

    /**
     * Test nlang() without context returns singular for untranslated singular string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularUntranslatedWithoutContextReturnsSingular()
    {
        $this->assertEquals('chair', $this->provider->nlang('chair', 'chairs', 1));
    }

    /**
     * Test nlang() without context returns plural for untranslated plural string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralUntranslatedWithoutContextReturnsPlural()
    {
        $this->assertEquals('chairs', $this->provider->nlang('chair', 'chairs', 2));
    }

    /**
     * Test nlang() with context and singular value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContext()
    {
        $this->assertEquals('%d Ei', $this->provider->nlang('%d egg', '%d eggs', 1, 'food'));
    }

    /**
     * Test nlang() with context and plural value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContext()
    {
        $this->assertEquals('%d Eier', $this->provider->nlang('%d egg', '%d eggs', 2, 'food'));
    }

    /**
     * Test nlang() with context returns singular for untranslated singular string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedSingularWithContextReturnsSingular()
    {
        $this->assertEquals('%d chair', $this->provider->nlang('%d chair', '%d chairs', 1, 'kitchen'));
    }

    /**
     * Test nlang() with context returns plural for untranslated plural string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangUntranslatedPluralWithContextReturnsPlural()
    {
        $this->assertEquals('%d chairs', $this->provider->nlang('%d chair', '%d chairs', 2, 'kitchen'));
    }

    /**
     * Test nlang() with superfluous context and singular value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithSuperfluousContextReturnsSingular()
    {
        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test nlang() with superfluous context and plural value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithSuperfluousContextReturnsPlural()
    {
        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2, 'people'));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextMissingReturnsSingular()
    {
        $this->assertEquals('%d egg', $this->provider->nlang('%d egg', '%d eggs', 1));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingReturnsPlural()
    {
        $this->assertEquals('%d eggs', $this->provider->nlang('%d egg', '%d eggs', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->provider->nlang('table', 'tables', 1));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->provider->nlang('table', 'tables', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingAndFakePluralReturnsPlural()
    {
        $this->assertEquals('banks', $this->provider->nlang('bank', 'banks', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangSingularWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->provider->nlang('bank', 'banks', 1, 'finance'));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @depends Lunr\Libraries\L10n\PHPL10nProviderBaseTest::testInit
     * @covers  Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function testNlangPluralWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->provider->nlang('bank', 'banks', 2, 'finance'));
    }

}

?>
