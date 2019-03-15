<?php

/**
 * This file contains the L10nProviderBaseTest class.
 *
 * @package    Lunr\L10n
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test methods for the abstract L10nProvider class.
 *
 * @covers Lunr\L10n\L10nProvider
 */
class L10nProviderBaseTest extends L10nProviderTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLanguageIsSetCorrectly(): void
    {
        $this->assertPropertyEquals('language', self::LANGUAGE);
    }

    /**
     * Test that the domain is correctly stored in the object.
     */
    public function testDomainIsSetCorrectly(): void
    {
        $this->assertPropertyEquals('domain', self::DOMAIN);
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testDefaultLanguageSetCorrectly(): void
    {
        $this->assertPropertyEquals('default_language', 'en_US');
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLocaleLocationSetCorrectly(): void
    {
        // /usr/bin/l10n by default
        $default_location = dirname($_SERVER['PHP_SELF']) . '/l10n';

        $this->assertPropertyEquals('locales_location', $default_location);
    }

    /**
     * Test that get_language() returns the set language.
     *
     * @covers Lunr\L10n\L10nProvider::get_language
     */
    public function testGetLanguageReturnsLanguage(): void
    {
        $this->assertEquals(self::LANGUAGE, $this->class->get_language());
    }

}

?>
