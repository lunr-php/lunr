<?php

/**
 * Factory class for providing Localization implementations
 * @author M2Mobi, Heinz Wiesinger
 */
class L10nFactory
{

    /**
     * Instance of the L10nProvider
     * @var array
     */
    private static $lprovider;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * This method returns an object with the appropriate localization
     * implementation provider
     * @param String $provider The localization implementation requested
     * @param String $language ISO-639-1 definition for the requested language (short code)
     * @return L10nProvider $return Instance of the localization provider requested
     */
    public static function get_localization($provider, $language)
    {
        switch($provider)
        {
            case "php":
                if (!isset(self::$lprovider[$provider]))
                {
                    self::$lprovider[$provider] = new L10nProviderPHP($language);
                }

                return self::$lprovider[$provider];
                break;
            case "gettext":
            default:
                if (!isset(self::$lprovider[$provider]))
                {
                    self::$lprovider[$provider] = new L10nProviderGettext($language);
                }

                return self::$lprovider[$provider];
                break;
        }
    }
}

?>
