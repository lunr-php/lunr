<?php

/**
 * Abstract Localization Provider class
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class L10nProvider
{

    /**
     * Constructor
     * @param String $language POSIX locale definition
     */
    abstract public function __construct($language);

    /**
     * Destructor
     */
    abstract public function __destruct();

    /**
     * Initialization method for setting up the provider
     * @param String $language POSIX locale definition
     * @return void
     */
    abstract protected function init($language);

    /**
     * Return a translated string
     * @param String $identifier Identifier for the requested string
     * @param String $context Context information fot the requested string
     * @return String $string Translated string, identifier by default
     */
    abstract public function lang($identifier, $context = "");

    /**
     * Return a translated string, with proper singular/plural
     * form
     * @param String $singular Identifier for the singular version of the string
     * @param String $plural Identifier for the plural version of the string
     * @param Integer $amount The amount the translation should be based on
     * @param String $context Context information fot the requested string
     * @return String $string Translated string, identifier by default
     */
    abstract public function nlang($singular, $plural, $amount, $context = "");

}

?>
