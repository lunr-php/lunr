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
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class L10n
{

    /**
     * Static list of supported languages
     * @var array
     */
    private static $languages;

    /**
     * Get list of supported languages from the filesystem.
     *
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
                    $path = $config['l10n']['locales'] . "/$file";
                    if ($file != '.' && $file != '..' && is_dir($path))
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
     * Set a cookie with the language information used for displaying strings.
     *
     * @param String $language The language to set
     *
     * @return String $language The POSIX locale that has been deemed most
     *                          appropriate
     */
    public static function set_language($language)
    {
        $lang = self::iso_to_posix($language);

        setcookie('lang', $lang, M2DateTime::delayed_timestamp('+1year'), '/');
        return $lang;
    }

    /**
     * Convert a language (if supported) from ISO 639-1 to POSIX locale format.
     *
     * @param String $language The language to convert on ISO 639-1 format
     *
     * @return String $locale The POSIX locale that has been deemed most
     *                          appropriate or the default if not found
     */
    public static function iso_to_posix($language)
    {
        global $config;
        $supported = self::get_supported_languages($language);

        foreach ($supported as $locale)
        {
            if (locale_filter_matches($locale, $language, FALSE))
            {
                return $locale;
            }
        }
        return $config['l10n']['default_language'];
    }

}

?>
