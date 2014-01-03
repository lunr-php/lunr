<?php

/**
 * This file contains a basic oauth connection
 * interface definition, meant to support login
 * through the service or to post messages to
 * it.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * OAuth connection interface
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
interface OAuthConnectionInterface
{

    /**
     * Constructor.
     *
     * @param String $token User access token
     */
    public function __construct($token);

    /**
     * Get the request token from the OAuth provider.
     *
     * @param String $callback URL to receive the callback from the OAuth provider
     *
     * @return Array $return Array containing the 'oauth_token_secret' and the
     *                       'request_token_secret' on success and FALSE otherwise
     */
    public function get_request_token($callback);

    /**
     * Get access token from the OAuth provider.
     *
     * @param String $oauth_token OAuth token
     * @param String $oauth_addon Request token secret
     *
     * @return Array $return Array containing the 'oauth token' and the 'oauth token secret',
     *                       FALSE on failure.
     */
    public function get_access_token($oauth_token, $oauth_addon);

    /**
     * Get user profile info from OAuth Service Provider.
     *
     * @param String $access_token        OAuth token
     * @param String $access_token_secret Request token secret
     *
     * @return Array $return Array containing the user profile information, FALSE otherwise
     */
    public function get_user_info($access_token, $access_token_secret = '');

    /**
     * Post a message to OAuth Service Provider.
     *
     * @param String        $access_token        OAuth access token
     * @param SocialMessage $message             SocialMessage object already filled
     * @param String        $access_token_secret Access token secret
     *
     * @return Boolean TRUE if the post to the Social Network was done properly, FALSE otherwise.
     *                 When it's FALSE, additionally is stored an error number (errno) and error
     *                 message (errmsg).
     *                 Possible error numbers: 401 for token expired or invalid, 403 for message
     *                 duplicated or other number for specific errors.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '');

}

?>
