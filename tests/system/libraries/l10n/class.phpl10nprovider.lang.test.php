<?php

/**
 * This file contains the PHPL10nProviderLangTest class.
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
 * This class contains the tests for the lang function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\PHPL10nProvider
 */
class PHPL10nProviderLangTest extends PHPL10nProviderTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpFull();
    }

    /**
     * Test lang() without context.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_without_context()
    {
        $this->assertEquals("Tisch", $this->provider->lang('table'));
    }

    /**
     * Test lang() without context returns identifier for untranslated string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_untranslated_without_context_returns_identifier()
    {
        $this->assertEquals("chair", $this->provider->lang('chair'));
    }

    /**
     * Test lang() with context.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_with_context()
    {
        $this->assertEquals("Bank", $this->provider->lang('bank', 'finance'));
    }

    /**
     * Test lang() with context returns identifier for untranslated string.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_untranslated_with_context_returns_identifier()
    {
        $this->assertEquals("chair", $this->provider->lang('chair', 'kitchen'));
    }

    /**
     * Test lang() with superfluous context.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_with_superfluous_context_returns_identifier()
    {
        $this->assertEquals("table", $this->provider->lang('table', 'kitchen'));
    }

    /**
     * Test lang() with context missing.
     *
     * @covers Lunr\Libraries\L10n\PHPL10nProvider::lang
     */
    public function test_lang_with_context_missing_returns_identifier()
    {
        $this->assertEquals("bank", $this->provider->lang('bank'));
    }

}

?>
