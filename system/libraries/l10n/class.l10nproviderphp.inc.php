<?php

class L10nProviderPHP extends L10nProvider
{

    /**
     * Constructor
     * @param String $language ISO-639-1 definition for the requested language (short code)
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
     * @param String $language ISO-639-1 definition for the requested language (short code)
     * @return void
     */
    private function init($language)
    {

    }

    /**
     * Return a translated string
     * @param String $identifier Identifier for the requested string
     * @return String $string Translated string, identifier by default
     */
    public function lang($identifier)
    {
        return $identifier;
    }

}

?>
