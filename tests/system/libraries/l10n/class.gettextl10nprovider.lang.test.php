<?php

/**
 * This file contains the GettextL10nProviderLangTest class.
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
 * @covers     Lunr\Libraries\L10n\GettextL10nProvider
 */
class GettextL10nProviderLangTest extends GettextL10nProviderTest
{

    /**
     * Test lang() without context.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_without_context()
    {
        $this->assertEquals("Tisch", $this->provider->lang('table'));
    }

    /**
     * Test lang() without context returns identifier for untranslated string.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_untranslated_without_context_returns_identifier()
    {
        $this->assertEquals("chair", $this->provider->lang('chair'));
    }

    /**
     * Test lang() with context.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_with_context()
    {
        $this->assertEquals("Bank", $this->provider->lang('bank', 'finance'));
    }

    /**
     * Test lang() with context returns identifier for untranslated string.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_untranslated_with_context_returns_identifier()
    {
        $this->assertEquals("chair", $this->provider->lang('chair', 'kitchen'));
    }

    /**
     * Test lang() with superfluous context.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_with_superfluous_context_returns_identifier()
    {
        $this->assertEquals("table", $this->provider->lang('table', 'kitchen'));
    }

    /**
     * Test lang() with context missing.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_with_context_missing_returns_identifier()
    {
        $this->assertEquals("bank", $this->provider->lang('bank'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_accessing_plural_with_singular_translates_singular()
    {
        $this->assertEquals("%d Mann", $this->provider->lang('%d man'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_accessing_plural_with_plural_returns_identifier()
    {
        $this->assertEquals("%d men", $this->provider->lang('%d men'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_accessing_plural_with_singular_and_context_translates_singular()
    {
        $this->assertEquals("%d Ei", $this->provider->lang('%d egg', 'food'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_accessing_plural_with_plural_and_context_returns_identifier()
    {
        $this->assertEquals("%d eggs", $this->provider->lang('%d eggs', 'food'));
    }

    /**
     * Test that lang() without specifying context and given a too long identifier returns the identifier.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_without_context_and_too_long_identifier_returns_identifier()
    {
        $identifier = "";
        for ($i=0; $i<4102; $i++)
        {
            $identifier .= "a";
        }

        $this->assertEquals($identifier, $this->provider->lang($identifier));
    }

    /**
     * Test that lang() given context and identifier too long returns the identifier.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Libraries\L10n\GettextL10nProvider::lang
     */
    public function test_lang_with_context_and_too_long_identifier_returns_identifier()
    {
        $identifier = "";
        for ($i=0; $i<4096; $i++)
        {
            $identifier .= "a";
        }

        $this->assertEquals($identifier, $this->provider->lang($identifier, 'aaaaaa'));
    }

}

?>
