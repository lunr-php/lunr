<?php

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

}

?>
