<?php

/**
 * This file contains the implementation of the Localization Factory.
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
 * Factory class for providing Localization implementations
 *
 * @category   Libraries
 * @package    L10n
 * @subpackage Libraries
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
        switch($provider)
        {
            case 'php':
                if (!isset(self::$lprovider[$provider]))
                {
                    self::$lprovider[$provider] =
                        new PHPL10nProvider($language);
                }

                return self::$lprovider[$provider];
                break;
            case 'gettext':
            default:
                if (!isset(self::$lprovider[$provider]))
                {
                    self::$lprovider[$provider] =
                        new GettextL10nProvider($language);
                }

                return self::$lprovider[$provider];
                break;
        }
    }

}

?>
