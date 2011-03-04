<?php

/**
 * This file contains the Localization helper class. It includes functions to
 * handle language definition, get supported languages of a project, etc
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Localization support class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class L10n
{

    /**
     * Static list of supported languages
     * @var array
     */
    private static $languages;

    /**
     * Get list of supported languages from the filesystem
     * Storing the values in a static attribute ensures the
     * filesystem is never parsed more than once per request
     *
     * @return array Supported languages
     */
    public static function get_supported_languages()
    {
        if (!isset(self::$languages))
        {
            global $config;
            self::$languages = array();
            if ($handle = opendir($config['l10n']['locales']))
            {
                while (FALSE !== ($file = readdir($handle)))
                {
                    if ($file != "." && $file != ".." && $file != ".gitignore")
                    {
                        self::$languages[] = $file;
                    }
                }
                closedir($handle);
            }
            self::$languages[] = $config['l10n']['default_language'];
        }
        return self::$languages;
    }

    /**
     * Set a cookie with the language information used for displaying strings
     *
     * @param String $language The language to set
     *
     * @return String $language The POSIX locale that has been deemed most
     *                          appropriate
     */
    public static function set_language($language)
    {
        global $config;
        require_once("class.m2datetime.inc.php");

        $supported = self::get_supported_languages($language);

        $lang = $config['l10n']['default_language'];
        foreach ($supported as $locale)
        {
            if (locale_filter_matches($locale, $language, false))
            {
                $lang = $locale;
            }
        }

        setcookie('lang', $lang, M2DateTime::delayed_timestamp("+1year"), '/');
        return $lang;
    }

}

?>
