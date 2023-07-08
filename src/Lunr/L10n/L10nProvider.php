<?php

/**
 * This file contains the abstract definition for a
 * Localization Provider. A Localization Provider
 * is a class accessing a low-level localization
 * infrastructure.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\L10n;

use Psr\Log\LoggerInterface;

/**
 * Abstract Localization Provider class
 */
abstract class L10nProvider
{

    use L10nTrait;

    /**
     * The language the provider has been initialized with
     * @var string
     */
    protected $language;

    /**
     * Localization domain.
     * @var string
     */
    protected $domain;

    /**
     * Constructor.
     *
     * @param string          $language POSIX locale definition
     * @param string          $domain   Localization domain
     * @param LoggerInterface $logger   Shared instance of a logger class
     */
    public function __construct($language, $domain, $logger)
    {
        $this->language = $language;
        $this->domain   = $domain;
        $this->logger   = $logger;

        $this->default_language = 'en_US';
        $this->locales_location = dirname($_SERVER['PHP_SELF']) . '/l10n';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->language);
        unset($this->default_language);
        unset($this->locales_location);
        unset($this->domain);
        unset($this->logger);
    }

    /**
     * Initialization method for setting up the provider.
     *
     * @param string $language POSIX locale definition
     *
     * @return void
     */
    abstract protected function init($language);

    /**
     * Get the language the provider has been initialized with.
     *
     * @return string $string Provider language
     */
    public function get_language()
    {
        return $this->language;
    }

    /**
     * Return a translated string.
     *
     * @param string $identifier Identifier for the requested string
     * @param string $context    Context information fot the requested string
     *
     * @return string $string Translated string, identifier by default
     */
    abstract public function lang($identifier, $context = '');

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param string $singular Identifier for the singular version of the
     *                         string
     * @param string $plural   Identifier for the plural version of the string
     * @param int    $amount   The amount the translation should be based on
     * @param string $context  Context information fot the requested string
     *
     * @return string $string Translated string, identifier by default
     */
    abstract public function nlang($singular, $plural, $amount, $context = '');

}

?>
