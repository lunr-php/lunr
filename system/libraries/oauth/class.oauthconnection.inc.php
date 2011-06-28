<?php

/**
 * This file contains an OAuth Connection Parent Class
 * for Twitter.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */

/**
 * Twitter OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
abstract class OAuthConnection implements OAuthConnectionInterface
{

    /**
     * Object to handle the API connection
     * @var Object
     */
    protected $handler;

    /**
     * API access token
     * @var String
     */
    protected $token;

    const NETWORK = 'unknown';

    public function __construct($token)
    {
        global $config;

        $this->token = $token;

        try
        {
            $this->handler = new OAuth(
                    $config['oauth'][NETWORK]['consumer_key'],
                    $config['oauth'][NETWORK]['consumer_secret'],
                    OAUTH_SIG_METHOD_HMACSHA1,
                    OAUTH_AUTH_TYPE_URI
                );
        }
        catch (Exception $e)
        {
           $this->handler = FALSE;
        }
    }

    public function __destruct()
    {
        unset($this->token);
        unset($this->handler);
    }

    /**
     * Get the request token from the OAuth provider.
     *
     * @param String $callback URL to receive the callback from the OAuth provider
     *
     * @return Array Array containing the 'oauth_token_secret' and the
     *              'request_token_secret' on success and FALSE otherwise
     */
    public function get_request_token($callback)
    {
        if ($this->handler)
        {
            global $config;

            try
            {
                return $this->handler->getRequestToken(
                        $config['oauth']['twitter']['request_token_url'],
                        $callback
                    );
            }
            catch (OAuthException $e)
            {
                Output::error('OauthException getting request token from ' . NETWORK .
                    'Error code : ' . $e.getCode() .
                    '; Message: ' . $e.getMessage(),
                    $config['oauth']['log']
                );

                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get access token from the OAuth provider.
     *
     * @param String $oauth_token          Oauth token
     * @param String $request_token_secret Request token secret
     *
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE on failure.
     */
    public function get_access_token($oauth_token, $request_token_secret)
    {
        if ($this->handler)
        {
            global $config;
            try
            {
                $this->handler->setToken($oauth_token, $request_token_secret);
                return $this->handler->getAccessToken($config['oauth']['twitter']['access_token_url']);
            }
            catch(OAuthException $e)
            {
                Output::error('OauthException getting access token from ' . NETWORK .
                                'Error code : ' . $e.getCode() .
                                '; Message: ' . $e.getMessage(),
                                $config['oauth']['log']
                    );

                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

}

?>
