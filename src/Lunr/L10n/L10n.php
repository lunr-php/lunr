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
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

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

    use L10nTrait;

    /**
     * Shared instance of a FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    private $fao;

    /**
     * Static list of supported languages
     * @var array
     */
    private static $languages;

    /**
     * Constructor.
     *
     * @param LoggerInterface                 $logger Shared instance of a Logger class.
     * @param FilesystemAccessObjectInterface $fao    Shared instance of a FilesystemAccessObject class.
     */
    public function __construct($logger, $fao)
    {
        $this->logger = $logger;
        $this->fao    = $fao;

        $this->default_language = 'en_US';
        $this->locales_location = dirname($_SERVER['PHP_SELF']) . '/l10n';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->fao);
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

        self::$languages = $this->fao->get_list_of_directories($this->locales_location);

        self::$languages[] = $this->default_language;
        self::$languages   = array_unique(self::$languages);

        return self::$languages;
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

        return $this->default_language;
    }

}

?>
