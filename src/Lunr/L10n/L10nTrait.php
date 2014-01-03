<?php

/**
 * This file contains the Localization helper trait.
 *
 * It includes shared functions to set the default language and the locales
 * location.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

/**
 * Localization support trait.
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
trait L10nTrait
{

    /**
     * Default language.
     * @var String
     */
    protected $default_language;

    /**
     * Locales location.
     * @var String
     */
    protected $locales_location;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Set the default language.
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    public function set_default_language($language)
    {
        $current = setlocale(LC_MESSAGES, 0);

        if (setlocale(LC_MESSAGES, $language) !== FALSE)
        {
            $this->default_language = $language;
            setlocale(LC_MESSAGES, $current);
        }
        else
        {
            $this->logger->warning('Invalid default language: ' . $language);
        }
    }

    /**
     * Set the location for language files.
     *
     * @param String $location Path to locale files
     *
     * @return void
     */
    public function set_locales_location($location)
    {
        if (file_exists($location) === TRUE)
        {
            $this->locales_location = $location;
        }
        else
        {
            $this->logger->warning('Invalid locales location: ' . $location);
        }
    }

}

?>
