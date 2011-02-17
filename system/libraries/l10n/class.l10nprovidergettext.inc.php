<?php

/**
 * Gettext Localization Provider class
 * @author M2Mobi, Heinz Wiesinger
 */
class L10nProviderGettext extends L10nProvider
{

    /**
     * Constructor
     * @param String $language POSIX locale definition
     */
    public function __construct($language)
    {
        $this->init($language);
    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * Initialization method for setting up the provider
     * @param String $language POSIX locale definition
     * @return void
     */
    private function init($language)
    {
        global $config;
        putenv('LANG=' . $language);
        setlocale(LC_ALL, "");
        setlocale(LC_MESSAGES, $language);
        setlocale(LC_CTYPE, $language);
        bindtextdomain($config['l10n']['domain'], $language);
        textdomain($config['l10n']['domain']);
    }

    /**
     * Return a translated string
     * @param String $identifier Identifier for the requested string
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier)
    {
        return gettext($identifier);
    }

    /**
     * Return a translated string, with proper singular/plural
     * form
     * @param String $singular Identifier for the singular version of the string
     * @param String $plural Identifier for the plural version of the string
     * @param Integer $amount The amount the translation should be based on
     * @return String $string Translated string, identifier by default
     */
    public function nlang($singular, $plural, $amount)
    {
        return ngettext($singular, $plural, $amount);
    }

}

?>
