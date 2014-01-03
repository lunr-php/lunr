<?php

/**
 * This file contains the L10nTest class.
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

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test methods for the L10n class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\L10n\L10n
 */
class L10nBaseTest extends L10nTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that $languages is initially empty.
     */
    public function testLanguagesEmpty()
    {
        $properties = $this->reflection->getStaticProperties();
        $languages  = $properties['languages'];

        $this->assertEmpty($languages);
    }

    /**
     * Test that the FilesystemAccessObject class is passed correctly.
     */
    public function testFAOIsPassedCorrectly()
    {
        $this->assertPropertySame('fao', $this->fao);
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testDefaultLanguageSetCorrectly()
    {
        $this->assertPropertyEquals('default_language', 'en_US');
    }

    /**
     * Test that the language is correctly stored in the object.
     */
    public function testLocaleLocationSetCorrectly()
    {
        // /usr/bin/l10n by default
        $default_location = dirname($_SERVER['PHP_SELF']) . '/l10n';

        $this->assertPropertyEquals('locales_location', $default_location);
    }

    /**
     * Test initial call to get_supported_languages().
     *
     * @depends testLanguagesEmpty
     * @covers  Lunr\L10n\L10n::get_supported_languages
     */
    public function testInitialGetSupportedLanguages()
    {
        $this->fao->expects($this->once())
                  ->method('get_list_of_directories')
                  ->with(dirname($_SERVER['PHP_SELF']) . '/l10n')
                  ->will($this->returnValue(array('de_DE', 'nl_NL')));

        $languages = $this->class->get_supported_languages();
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test that get_supported_languages() populated $languages.
     *
     * @depends testInitialGetSupportedLanguages
     */
    public function testLanguagesPopulated()
    {
        $properties = $this->reflection->getStaticProperties();
        $languages  = $properties['languages'];
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test get_supported_languages() when it was already executed before.
     *
     * @depends testLanguagesPopulated
     * @covers  Lunr\L10n\L10n::get_supported_languages
     */
    public function testCachedGetSupportedLanguages()
    {
        $this->fao->expects($this->never())
                  ->method('get_list_of_directories');

        $languages = $this->class->get_supported_languages();
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test iso_to_posix() with supported languages.
     *
     * @param String $iso   ISO language definition
     * @param String $posix POSIX language definition
     *
     * @dataProvider supportedLanguagesProvider
     * @depends      testCachedGetSupportedLanguages
     * @requires     extension intl
     * @covers       Lunr\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForSupportedLanguages($iso, $posix)
    {
        $this->assertEquals($posix, $this->class->iso_to_posix($iso));
    }

    /**
     * Test iso_to_posix() with unsupported languages.
     *
     * @param String $iso ISO language definition
     *
     * @dataProvider unsupportedLanguagesProvider
     * @depends      testCachedGetSupportedLanguages
     * @requires     extension intl
     * @covers       Lunr\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForUnsupportedLanguages($iso)
    {
        $this->assertEquals('en_US', $this->class->iso_to_posix($iso));
    }

}

?>
