<?php

/**
 * This file contains the PHPL10nProviderNlangTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_without_context()
    {
       $this->assertEquals("%d Mann", $this->provider->nlang('%d man', '%d men', 1));
    }

    /**
     * Test nlang() without context and plural value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_without_context()
    {
        $this->assertEquals("%d Männer", $this->provider->nlang('%d man', '%d men', 2));
    }

    /**
     * Test nlang() without context returns singular for untranslated singular string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_untranslated_without_context_returns_singular()
    {
        $this->assertEquals("chair", $this->provider->nlang('chair', 'chairs', 1));
    }

    /**
     * Test nlang() without context returns plural for untranslated plural string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_untranslated_without_context_returns_plural()
    {
        $this->assertEquals("chairs", $this->provider->nlang('chair', 'chairs', 2));
    }

    /**
     * Test nlang() with context and singular value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_with_context()
    {
        $this->assertEquals("%d Ei", $this->provider->nlang('%d egg', '%d eggs', 1, 'food'));
    }

    /**
     * Test nlang() with context and plural value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_with_context()
    {
        $this->assertEquals("%d Eier", $this->provider->nlang('%d egg', '%d eggs', 2, 'food'));
    }

    /**
     * Test nlang() with context returns singular for untranslated singular string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_untranslated_singular_with_context_returns_singular()
    {
        $this->assertEquals("%d chair", $this->provider->nlang('%d chair', '%d chairs', 1, 'kitchen'));
    }

    /**
     * Test nlang() with context returns plural for untranslated plural string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_untranslated_plural_with_context_returns_plural()
    {
        $this->assertEquals("%d chairs", $this->provider->nlang('%d chair', '%d chairs', 2, 'kitchen'));
    }

    /**
     * Test nlang() with superfluous context and singular value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_with_superfluous_context_returns_singular()
    {
        $this->assertEquals("%d man", $this->provider->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test nlang() with superfluous context and plural value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_with_superfluous_context_returns_plural()
    {
        $this->assertEquals("%d men", $this->provider->nlang('%d man', '%d men', 2, 'people'));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_with_context_missing_returns_singular()
    {
        $this->assertEquals("%d egg", $this->provider->nlang('%d egg', '%d eggs', 1));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_with_context_missing_returns_plural()
    {
        $this->assertEquals("%d eggs", $this->provider->nlang('%d egg', '%d eggs', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_without_context_and_fake_plural_translates_singular()
    {
        $this->assertEquals("Tisch", $this->provider->nlang('table', 'tables', 1));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_without_context_and_fake_plural_translates_singular()
    {
        $this->assertEquals("Tisch", $this->provider->nlang('table', 'tables', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_with_context_missing_and_fake_plural_returns_plural()
    {
        $this->assertEquals("banks", $this->provider->nlang('bank', 'banks', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_singular_with_context_and_fake_plural_translates_singular()
    {
        $this->assertEquals("Bank", $this->provider->nlang('bank', 'banks', 1, 'finance'));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::nlang
     */
    public function test_nlang_plural_with_context_and_fake_plural_translates_singular()
    {
        $this->assertEquals("Bank", $this->provider->nlang('bank', 'banks', 2, 'finance'));
    }

}

?>
