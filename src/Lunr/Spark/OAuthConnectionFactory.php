<?php

/**
 * This file contains an OAuth Connection Factory
 * that returns the respective OAuth Connection for
 * the specified Service Provider.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * Oauth Connection Factory class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class OAuthConnectionFactory
{

    /**
     * Return a OauthConnection for the specified provider.
     *
     * @param String $provider lowercase name of the OAuth Provider
     * @param String $token    User access token
     *
     * @return OAuthConnection $connection An OAuth connection to the specified
     *                                     Service
     */
    public static function get_connection($provider, $token)
    {
        switch ($provider)
        {
            case 'twitter':
                return new TwitterConnection($token);
                break;
            case 'linkedin':
                return new LinkedinConnection($token);
                break;
            case 'facebook':
            default:
                return new FacebookConnection($token);
                break;
        }
    }

}

?>
