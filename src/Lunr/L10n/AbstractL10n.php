<?php

/**
 * This file contains the Localization helper trait.
 *
 * It includes shared functions to set the default language and the locales
 * location.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use DirectoryIterator;
use Psr\Log\LoggerInterface;

/**
 * Localization support trait.
 */
abstract class AbstractL10n
{

    /**
     * Default language.
     * @var string
     */
    protected $default_language;

    /**
     * Locales location.
     * @var string
     */
    protected string $locales_location;

    /**
     * Locales location iterator.
     * @var DirectoryIterator
     */
    protected DirectoryIterator $locales_iterator;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger           Shared instance of a Logger class.
     * @param string          $locales_location Location of translation files
     */
    public function __construct($logger, $locales_location)
    {
        $this->logger = $logger;

        $this->default_language = 'en_US';

        $this->set_locales_location($locales_location);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->default_language);
        unset($this->locales_location);
    }

    /**
     * Set the default language.
     *
     * @param string $language POSIX locale definition
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
     * @param string $location Path to locale files
     *
     * @return void
     */
    public function set_locales_location($location)
    {
        // This will throw if $location does not exist, isn't a directory
        // or we don't have permission to access it.
        $this->locales_iterator = new DirectoryIterator($location);

        $this->locales_location = $location;
    }

}

?>
