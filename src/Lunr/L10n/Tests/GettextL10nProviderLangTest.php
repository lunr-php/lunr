<?php

/**
 * This file contains the GettextL10nProviderLangTest class.
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

use Lunr\L10n\GettextL10nProvider;

/**
 * This class contains the tests for the lang function.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\GettextL10nProvider
 */
class GettextL10nProviderLangTest extends GettextL10nProviderTest
{

    /**
     * Test lang() without context.
     *
     * @depends  Lunr\EnvironmentTest::testL10nFiles
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithoutContext()
    {
        $this->assertEquals('Tisch', $this->class->lang('table'));
    }

    /**
     * Test lang() without context returns identifier for untranslated string.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangUntranslatedWithoutContextReturnsIdentifier()
    {
        $this->assertEquals('chair', $this->class->lang('chair'));
    }

    /**
     * Test lang() with context.
     *
     * @depends  Lunr\EnvironmentTest::testL10nFiles
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithContext()
    {
        $this->assertEquals('Bank', $this->class->lang('bank', 'finance'));
    }

    /**
     * Test lang() with context returns identifier for untranslated string.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangUntranslatedWithContextReturnsIdentifier()
    {
        $this->assertEquals('chair', $this->class->lang('chair', 'kitchen'));
    }

    /**
     * Test lang() with superfluous context.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithSuperfluousContextReturnsIdentifier()
    {
        $this->assertEquals('table', $this->class->lang('table', 'kitchen'));
    }

    /**
     * Test lang() with context missing.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithContextMissingReturnsIdentifier()
    {
        $this->assertEquals('bank', $this->class->lang('bank'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @depends  Lunr\EnvironmentTest::testL10nFiles
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangAccessingPluralWithSingularTranslatesSingular()
    {
        $this->assertEquals('%d Mann', $this->class->lang('%d man'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangAccessingPluralWithPluralReturnsIdentifier()
    {
        $this->assertEquals('%d men', $this->class->lang('%d men'));
    }

    /**
     * Test lang() accessing a plural value with singular.
     *
     * @depends  Lunr\EnvironmentTest::testL10nFiles
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangAccessingPluralWithSingularAndContextTranslatesSingular()
    {
        $this->assertEquals('%d Ei', $this->class->lang('%d egg', 'food'));
    }

    /**
     * Test lang() accessing a plural value with plural.
     *
     * @depends  Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @requires extension gettext
     * @covers   Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangAccessingPluralWithPluralAndContextReturnsIdentifier()
    {
        $this->assertEquals('%d eggs', $this->class->lang('%d eggs', 'food'));
    }

    /**
     * Test that lang() without specifying context and given a too long identifier returns the identifier.
     *
     * @covers Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithoutContextAndTooLongIdentifierReturnsIdentifier()
    {
        $identifier = '';
        for ($i = 0; $i < 4102; $i++)
        {
            $identifier .= 'a';
        }

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->assertEquals($identifier, $this->class->lang($identifier));
    }

    /**
     * Test that lang() given context and identifier too long returns the identifier.
     *
     * @covers Lunr\L10n\GettextL10nProvider::lang
     */
    public function testLangWithContextAndTooLongIdentifierReturnsIdentifier()
    {
        $identifier = '';
        for ($i = 0; $i < 4096; $i++)
        {
            $identifier .= 'a';
        }

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->assertEquals($identifier, $this->class->lang($identifier, 'aaaaaa'));
    }

}

?>
