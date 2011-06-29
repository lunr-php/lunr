<?php

/**
 * This file contains an OAuth Connection Class
 * for Twitter.
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
 * Twitter OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class TwitterConnection extends OAuthConnection
{
    const NETWORK = 'twitter';

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
     * Get user profile info from Twitter
     *
     * @param String $access_oauth_token  Oauth token
     * @param String $access_token_secret Request token secret
     *
     * @return Array Array containing the user profile information, FALSE otherwise
     */
    public function get_user_info($access_oauth_token, $access_token_secret)
    {
        global $config;

        $this->handler->setToken($access_oauth_token, $access_token_secret);
        try
        {
            $data = $this->handler->fetch($config['social']['twitter']['verify_url']);
            return $this->handler->getLastResponse();
        }
        catch (OAuthException $e)
        {
            Output::error('OauthException retrieving user info from Twitter.' .
                            'Error code : ' . $e.getCode() .
                            '; Message: ' . $e.getMessage(),
                            $config['oauth']['log']
                );

            return FALSE;
        }
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
        return $this->handler->getAccessToken($config['social']['twitter']['access_token_url']);
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

?>