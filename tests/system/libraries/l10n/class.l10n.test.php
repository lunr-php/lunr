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
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

use Lunr\Libraries\L10n\L10n;
use Lunr\Libraries\Core\M2DateTime;

include_once("conf.l10n.inc.php");

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

    protected $languages;

    protected function setUp()
    {
        global $config;

        $this->languages = array();
        if ($handle = opendir($config['l10n']['locales']))
        {
            while (FALSE !== ($file = readdir($handle)))
            {
                $path = $config['l10n']['locales'] . "/$file";
                if ($file != "." && $file != ".." && is_dir($path))
                {
                    $this->languages[] = $file;
                }
            }
        }
        closedir($handle);
        $this->languages[] = $config['l10n']['default_language'];
    }

    /**
     * Test the static function get_supported_languages()
     * @covers Lunr\Libraries\L10n\L10n::get_supported_languages
     */
    public function testGetSupportedLanguages()
    {
        $this->assertEquals($this->languages, L10n::get_supported_languages());
    }

    /**
    * Test the static function iso_to_posix()
    * @depends testGetSupportedLanguages
    * @dataProvider languageProvider
    * @covers Lunr\Libraries\L10n\L10n::iso_to_posix
    */
    public function testIsoToPosix($posix, $iso)
    {
        if (in_array($posix, $this->languages))
        {
            $this->assertEquals($posix, L10n::iso_to_posix($iso));
        }
        else
        {
            global $config;
            $this->assertEquals($config['l10n']['default_language'], L10n::iso_to_posix($iso));
        }
    }

    /**
     * Test the static function set_language()
     * @depends M2DateTimeTest::testDelayedTimestamp
     * @depends testGetSupportedLanguages
     * @depends testIsoToPosix
     * @dataProvider languageProvider
     * @covers Lunr\Libraries\L10n\L10n::set_language
     * @runInSeparateProcess
     */
    public function testSetLanguage($locale, $language)
    {
        if (in_array($locale, $this->languages))
        {
            $this->assertEquals($locale, L10n::set_language($language));
        }
        else
        {
            global $config;
            $this->assertEquals($config['l10n']['default_language'], L10n::set_language($language));
        }
    }

    public function languageProvider()
    {
        return array(array("en_GB", "en"), array("nl_NL", "nl"), array("de_DE", "de"));
    }
}

?>
