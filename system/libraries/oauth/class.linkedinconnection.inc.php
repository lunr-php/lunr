<?php

/**
 * This file contains an OAuth Connection Class
 * for Linkedin.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 */

/**
 * Linkedin OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class LinkedinConnection extends OAuthConnection
{

    const NETWORK = 'linkedin';

    /**
     * Constructor.
     *
     * @param String $token User access token
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Get the request token.
     *
     * @param String $callback Url to redirect back
     *
     * @return Array Array containing the 'oauth token secret' and the 'request token secret'
     */
    public function get_request_token($callback)
    {
        global $config;

        return $this->handler->getRequestToken(
                $config['social']['linkedin']['request_token_url'],
                $callback
            );
    }

    /**
     * Get access token.
     *
     * @param String $oauth_token          Oauth token
     * @param String $request_token_secret Request token secret
     *
     * @return Array containing the 'oauth token' and the 'oauth token secret'
     */
    public function get_access_token($oauth_token, $request_token_secret)
    {
        global $config;

        $this->handler->setToken($oauth_token, $request_token_secret);
        return $this->handler->getAccessToken($config['social']['linkedin']['access_token_url']);
    }

    public function login()
    {

    }

    public function get_user_info()
    {

    }

    public function post_message()
    {

    }
}