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
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\L10n;

use Lunr\Libraries\Core\DateTime;
use Lunr\Libraries\Core\Configuration;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the L10n class.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\L10n\L10n
 */
class L10nTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the L10n class.
     * @var L10n
     */
    private $l10n;

    /**
     * Reflection Instance of the L10n class.
     */
    private $l10n_reflection;

    /**
     * Array of supported languages.
     * @var array
     */
    private $languages;

    /**
     * Default language to test with.
     * @var String
     */
    const DEFAULT_LANG = 'nl_NL';

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $config                             = new Configuration(array());
        $config['l10n']                     = array();
        $config['l10n']['default_language'] = self::DEFAULT_LANG;
        $config['l10n']['locales']          = dirname(__FILE__) . '/../../../statics/l10n';

        $datetime = $this->getMock('Lunr\Libraries\Core\DateTime');
        $datetime->expects($this->any())
                 ->method('get_delayed_timestamp')
                 ->will($this->returnValue(strtotime('+1 year')));

        $this->l10n = new L10n($datetime, $config);

        $this->l10n_reflection = new ReflectionClass('Lunr\Libraries\L10n\L10n');

        $this->languages = array('de_DE', 'en_GB', 'nl_NL');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->l10n);
        unset($this->l10n_reflection);
        unset($this->languages);
    }

    /**
     * Test that $languages is initially empty.
     */
    public function testLanguagesEmpty()
    {
        $properties = $this->l10n_reflection->getStaticProperties();
        $languages  = $properties['languages'];
        $this->assertEmpty($languages);
    }

    /**
     * Test initial call to get_supported_languages().
     *
     * @depends testLanguagesEmpty
     * @covers  Lunr\Libraries\L10n\L10n::get_supported_languages
     */
    public function testInitialGetSupportedLanguages()
    {
        $languages = $this->l10n->get_supported_languages();
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
        $properties = $this->l10n_reflection->getStaticProperties();
        $languages  = $properties['languages'];
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test get_supported_languages() when it was already executed before.
     *
     * @depends testLanguagesPopulated
     * @covers  Lunr\Libraries\L10n\L10n::get_supported_languages
     */
    public function testCachedGetSupportedLanguages()
    {
        $languages = $this->l10n->get_supported_languages();
        sort($languages);
        $this->assertEquals($this->languages, $languages);
    }

    /**
     * Test iso_to_posix() with supported languages.
     *
     * @param String $iso   ISO language definition
     * @param String $posix POSIX language definition
     *
     * @depends      testCachedGetSupportedLanguages
     * @dataProvider supportedLanguagesProvider
     * @covers       Lunr\Libraries\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForSupportedLanguages($iso, $posix)
    {
        $this->assertEquals($posix, $this->l10n->iso_to_posix($iso));
    }

    /**
     * Test iso_to_posix() with unsupported languages.
     *
     * @param String $iso ISO language definition
     *
     * @depends      testCachedGetSupportedLanguages
     * @dataProvider unsupportedLanguagesProvider
     * @covers       Lunr\Libraries\L10n\L10n::iso_to_posix
     */
    public function testIsoToPosixForUnsupportedLanguages($iso)
    {
        $this->assertEquals(self::DEFAULT_LANG, $this->l10n->iso_to_posix($iso));
    }

    /**
     * Test that we do not have an existing cookie polluting this test.
     */
    public function testCookieNotSet()
    {
        $this->assertFalse(isset($_COOKIE['lang']));
    }

    /**
     * Test set_language for supported languages.
     *
     * @param String $language ISO language definition
     * @param String $locale   POSIX language definition
     *
     * @runInSeparateProcess
     *
     * @depends      testIsoToPosixForSupportedLanguages
     * @dataProvider supportedLanguagesProvider
     * @covers       Lunr\Libraries\L10n\L10n::set_language
     */
    public function testSetLanguageForSupportedLanguages($language, $locale)
    {
        $this->assertEquals($locale, $this->l10n->set_language($language));
    }

    /**
     * Test set_language for unsupported languages.
     *
     * @param String $language ISO language definition
     *
     * @runInSeparateProcess
     *
     * @depends      testIsoToPosixForUnsupportedLanguages
     * @dataProvider unsupportedLanguagesProvider
     * @covers       Lunr\Libraries\L10n\L10n::set_language
     */
    public function testSetLanguageForUnsupportedLanguages($language)
    {
        $this->assertEquals(self::DEFAULT_LANG, $this->l10n->set_language($language));
    }

    /**
     * Test set_language sets a cookie correctly.
     *
     * @param String $language ISO language definition
     * @param String $locale   POSIX language definition
     *
     * @runInSeparateProcess
     *
     * @depends      testCookieNotSet
     * @depends      testIsoToPosixForSupportedLanguages
     * @dataProvider supportedLanguagesProvider
     * @covers       Lunr\Libraries\L10n\L10n::set_language
     */
    public function testSetLanguageSetsCookie($language, $locale)
    {
        ///TODO: Requires a cookie class
    }

    /**
     * Unit Test Data Provider for supported languages.
     *
     * @return array $languages Array of supported languages
     */
    public function supportedLanguagesProvider()
    {
        $languages   = array();
        $languages[] = array('en', 'en_GB');
        $languages[] = array('nl', 'nl_NL');

        return $languages;
    }

    /**
     * Unit Test Data Provider for unsupported languages.
     *
     * @return array $languages Array of unsupported languages
     */
    public function unsupportedLanguagesProvider()
    {
        $languages   = array();
        $languages[] = array('fr', 'fr_FR');

        return $languages;
    }

}

?>
