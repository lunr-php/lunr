<?php

/**
 * This file contains the abstract definition for the
 * PHP array Localization Provider.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * PHP (array) Localization Provider class
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class L10nProviderPHP extends L10nProvider
{

    /**
     * Constructor.
     *
     * @param String $language POSIX locale definition
     */
    public function __construct($language)
    {
        $this->init($language);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {

    }

    /**
     * Initialization method for setting up the provider.
     *
     * @param String $language POSIX locale definition
     *
     * @return void
     */
    protected function init($language)
    {

    }

    /**
     * Return a translated string.
     *
     * @param String $identifier Identifier for the requested string
     * @param String $context    Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier, $context = "")
    {
        return $identifier;
    }

    /**
     * Return a translated string, with proper singular/plural form.
     *
     * @param String  $singular Identifier for the singular version of
     *                          the string
     * @param String  $plural   Identifier for the plural version of the string
     * @param Integer $amount   The amount the translation should be based on
     * @param String  $context  Context information fot the requested string
     *
     * @return String $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount, $context = "")
    {
        return ($amount == 1 ? $singular : $plural);
    }

}

?>
