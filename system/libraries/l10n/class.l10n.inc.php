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
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\L10n;
use Lunr\Libraries\Core\DateTime;
use UnexpectedValueException;
use DirectoryIterator;

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
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Reference to the Configuration class.
     * @var Configuration
     */
    private $configuration;

    /**
     * Static list of supported languages
     * @var array
     */
    private static $languages;

    /**
     * Constructor.
     *
     * @param DateTime      $datetime       Instance of the DateTime class
     * @param Configuration &$configuration Reference to the Configuration class
     */
    public function __construct($datetime, &$configuration)
    {
        $this->datetime = $datetime;
        $this->configuration =& $configuration;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
    }

    /**
     * Get list of supported languages from the filesystem.
     *
     * Storing the values in a static attribute ensures the
     * filesystem is never parsed more than once per request
     *
     * @return array Supported languages
     */
    public function get_supported_languages()
    {
        if (isset(self::$languages))
        {
            return self::$languages;
        }

        self::$languages = array();

        try
        {
            $dir = new DirectoryIterator($this->configuration['l10n']['locales']);
            foreach ($dir as $file)
            {
                if (!$file->isDot() && $file->isDir())
                {
                    self::$languages[] = $dir->getFilename();
                }
            }
        }
        catch(UnexpectedValueException $e)
        {
            //Nothing to do
        }

        self::$languages[] = $this->configuration['l10n']['default_language'];
        self::$languages   = array_unique(self::$languages);

        return self::$languages;
    }

    /**
     * Set a cookie with the language information used for displaying strings.
     *
     * @param String $language The language to set
     *
     * @return String $lang The POSIX locale that has been deemed most
     *                      appropriate
     */
    public function set_language($language)
    {
        $lang = $this->iso_to_posix($language);
        setcookie('lang', $lang, $this->datetime->get_delayed_timestamp('+1year'), '/');
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
    public function iso_to_posix($language)
    {
        $supported = $this->get_supported_languages();

        foreach ($supported as $locale)
        {
            if (locale_filter_matches($locale, $language, FALSE))
            {
                return $locale;
            }
        }
        return $this->configuration['l10n']['default_language'];
    }

}

?>
