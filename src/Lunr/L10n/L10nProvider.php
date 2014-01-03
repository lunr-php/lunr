<?php

/**
 * This file contains the abstract definition for a
 * Localization Provider. A Localization Provider
 * is a class accessing a low-level localization
 * infrastructure.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\L10n;

/**
 * Abstract Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class L10nProvider
{

    use L10nTrait;

    /**
     * The language the provider has been initialized with
     * @var String
     */
    protected $language;

    /**
     * Localization domain.
     * @var String
     */
    protected $domain;

    /**
     * Constructor.
     *
     * @param String          $language POSIX locale definition
     * @param String          $domain   Localization domain
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
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    abstract protected function init($language);

    /**
     * Get the language the provider has been initialized with.
     *
     * @return String $string Provider language
     */
    public function get_language()
    {
        return $this->language;
    }

    /**
     * Return a translated string.
     *
     * @param String $identifier Identifier for the requested string
     * @param String $context    Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    abstract public function lang($identifier, $context = '');

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param String  $singular Identifier for the singular version of the
     *                          string
     * @param String  $plural   Identifier for the plural version of the string
     * @param Integer $amount   The amount the translation should be based on
     * @param String  $context  Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    abstract public function nlang($singular, $plural, $amount, $context = '');

}

?>
