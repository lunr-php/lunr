<?php

require_once("class.l10n.inc.php");
require_once("conf.l10n.inc.php");

/**
 * This tests Lunr's L10n class
 * @covers L10n
 */
class L10nTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function get_supported_languages()
     * @covers L10n::get_supported_languages
     */
    public function testGetSupportedLanguages()
    {
        global $config;
        $languages = array();
        if ($handle = opendir($config['l10n']['locales']))
        {
            while (FALSE !== ($file = readdir($handle)))
            {
                if ($file != "." && $file != ".." && $file != ".gitignore")
                {
                    $languages[] = $file;
                }
            }
        }
        closedir($handle);
        $languages[] = $config['l10n']['default_language'];
        $this->assertEquals(L10n::get_supported_languages(), $languages);
        return $languages;
    }

}

?>
