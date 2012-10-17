<?php

/**
 * This file contains the abstract definition for a
 * Localization Provider. A Localization Provider
 * is a class accessing a low-level localization
 * infrastructure.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\L10n;

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

    /**
     * The language the provider has been initialized with
     * @var String
     */
    protected $language;

    /**
     * Constructor.
     *
     * @param String $language POSIX locale definition
     */
    public function __construct($language)
    {
        $this->language = $language;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->language);
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
