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
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
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
class GettextL10nProviderNlangTest extends GettextL10nProviderTest
{

    /**
     * Test nlang() without context and singular value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithoutContext()
    {
        $this->assertEquals('%d Mann', $this->provider->nlang('%d man', '%d men', 1));
    }

    /**
     * Test nlang() without context and plural value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithoutContext()
    {
        $this->assertEquals('%d Männer', $this->provider->nlang('%d man', '%d men', 2));
    }

    /**
     * Test nlang() without context returns singular for untranslated singular string.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularUntranslatedWithoutContextReturnsSingular()
    {
        $this->assertEquals('chair', $this->provider->nlang('chair', 'chairs', 1));
    }

    /**
     * Test nlang() without context returns plural for untranslated plural string.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralUntranslatedWithoutContextReturnsPlural()
    {
        $this->assertEquals('chairs', $this->provider->nlang('chair', 'chairs', 2));
    }

    /**
     * Test nlang() with context and singular value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithContext()
    {
        $this->assertEquals('%d Ei', $this->provider->nlang('%d egg', '%d eggs', 1, 'food'));
    }

    /**
     * Test nlang() with context and plural value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithContext()
    {
        $this->assertEquals('%d Eier', $this->provider->nlang('%d egg', '%d eggs', 2, 'food'));
    }

    /**
     * Test nlang() with context returns singular for untranslated singular string.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangUntranslatedSingularWithContextReturnsSingular()
    {
        $this->assertEquals('%d chair', $this->provider->nlang('%d chair', '%d chairs', 1, 'kitchen'));
    }

    /**
     * Test nlang() with context returns plural for untranslated plural string.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangUntranslatedPluralWithContextReturnsPlural()
    {
        $this->assertEquals('%d chairs', $this->provider->nlang('%d chair', '%d chairs', 2, 'kitchen'));
    }

    /**
     * Test nlang() with superfluous context and singular value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithSuperfluousContextReturnsSingular()
    {
        $this->assertEquals('%d man', $this->provider->nlang('%d man', '%d men', 1, 'people'));
    }

    /**
     * Test nlang() with superfluous context and plural value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithSuperfluousContextReturnsPlural()
    {
        $this->assertEquals('%d men', $this->provider->nlang('%d man', '%d men', 2, 'people'));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithContextMissingReturnsSingular()
    {
        $this->assertEquals('%d egg', $this->provider->nlang('%d egg', '%d eggs', 1));
    }

    /**
     * Test nlang() with context missing and singular value.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingReturnsPlural()
    {
        $this->assertEquals('%d eggs', $this->provider->nlang('%d egg', '%d eggs', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->provider->nlang('table', 'tables', 1));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithoutContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Tisch', $this->provider->nlang('table', 'tables', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithContextMissingAndFakePluralReturnsPlural()
    {
        $this->assertEquals('banks', $this->provider->nlang('bank', 'banks', 2));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangSingularWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->provider->nlang('bank', 'banks', 1, 'finance'));
    }

    /**
     * Test nlang() with context missing and fake plural.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testL10nFiles
     * @depends Lunr\L10n\Tests\GettextL10nProviderBaseTest::testInit
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangPluralWithContextAndFakePluralTranslatesSingular()
    {
        $this->assertEquals('Bank', $this->provider->nlang('bank', 'banks', 2, 'finance'));
    }

    /**
     * Test that nlang() without specifying context and given a too long identifier returns the identifier.
     *
     * @runInSeparateProcess
     *
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangWithoutContextAndTooLongIdentifierReturnsIdentifier()
    {
        $identifier = '';
        for ($i = 0; $i < 4102; $i++)
        {
            $identifier .= 'a';
        }

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->assertEquals($identifier, $this->provider->nlang($identifier, 'plural', 1));
    }

    /**
     * Test that nlang() given context and identifier too long returns the identifier.
     *
     * @runInSeparateProcess
     *
     * @covers  Lunr\L10n\GettextL10nProvider::nlang
     */
    public function testNlangWithContextAndTooLongIdentifierReturnsIdentifier()
    {
        $identifier = '';
        for ($i = 0; $i < 4096; $i++)
        {
            $identifier .= 'a';
        }

        $this->logger->expects($this->once())
                     ->method('warning');

        $this->assertEquals($identifier, $this->provider->nlang($identifier, 'plural', 1, 'aaaaaa'));
    }

}

?>
