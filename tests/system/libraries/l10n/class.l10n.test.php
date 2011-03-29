<?php

require_once("class.l10n.inc.php");
require_once("conf.l10n.inc.php");

/**
 * This tests Lunr's L10n class
 * @covers L10n
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
     * @covers L10n::get_supported_languages
     */
    public function testGetSupportedLanguages()
    {
        $this->assertEquals($this->languages, L10n::get_supported_languages());
    }

    /**
    * Test the static function iso_to_posix()
    * @depends testGetSupportedLanguages
    * @dataProvider languageProvider
    * @covers L10n::iso_to_posix
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
     * @covers L10n::set_language
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
