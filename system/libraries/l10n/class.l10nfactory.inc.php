<?php

/**
 * This file contains the implementation of the Localization Factory.
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
 * Factory class for providing Localization implementations
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class L10nFactory
{

    /**
     * Instance of the L10nProvider
     * @var array
     */
    private static $lprovider;

    /**
     * Returns an object with the appropriate localization implementation provider.
     *
     * @param String $provider The localization implementation requested
     * @param String $language POSIX locale definition
     *
     * @return L10nProvider $return Instance of the localization provider
     *                              requested
     */
    public static function get_localization($provider, $language)
    {
        require_once("class.l10nprovider.inc.php");
        switch($provider)
        {
            case "php":
                if (!isset(self::$lprovider[$provider]))
                {
                    require_once("class.l10nproviderphp.inc.php");
                    self::$lprovider[$provider] =
                        new L10nProviderPHP($language);
                }

                return self::$lprovider[$provider];
                break;
            case "gettext":
            default:
                if (!isset(self::$lprovider[$provider]))
                {
                    require_once("class.l10nprovidergettext.inc.php");
                    self::$lprovider[$provider] =
                        new L10nProviderGettext($language);
                }

                return self::$lprovider[$provider];
                break;
        }
    }

}

?>
