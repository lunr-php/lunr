<?php

/**
 * This file contains an abstract OAuth Connection Parent Class
 * for grouping the common code between the children.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

use Lunr\Core\Output;

/**
 * OAuth Connection Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
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

    /**
     * Error number (401 when token expired, 403 if message duplicated, another number otherwise)
     * @var Integer
     */
    protected $errno;

    /**
     * Error message
     * @var String
     */
    protected $errmsg;

    /**
     * Name of the OAuth Service to connect to.
     * @var String
     */
    const NETWORK = 'unknown';

    /**
     * Constructor.
     *
     * @param String $token User access token
     */
    public function __construct($token)
    {
        global $config;

        $this->token = $token;

        try
        {
            $this->handler = new \OAuth(
                $config['oauth'][static::NETWORK]['consumerkey'],
                $config['oauth'][static::NETWORK]['consumersecret'],
                OAUTH_SIG_METHOD_HMACSHA1,
                OAUTH_AUTH_TYPE_URI
            );
        }
        catch (Exception $e)
        {
            $this->handler = FALSE;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->token);
        unset($this->handler);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to errno, errmsg.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'errno':
            case 'errmsg':
                return $this->{$name};
                break;
            default:
                return NULL;
                break;
        }
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
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;

        try
        {
            return $this->handler->getRequestToken(
                $config['oauth'][static::NETWORK]['requesttokenurl'],
                $callback
            );
        }
        catch (\OAuthException $e)
        {
            Output::error('OauthException getting request token from ' . static::NETWORK .
                ' Error code : ' . $e->getCode() .
                '; Message: ' . $e->getMessage(),
                $config['oauth']['log']
            );

            return FALSE;
        }
    }

    /**
     * Get access token from the OAuth provider.
     *
     * @param String $oauth_token          OAuth token
     * @param String $request_token_secret Request token secret
     *
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE on failure.
     */
    public function get_access_token($oauth_token, $request_token_secret)
    {
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;

        try
        {
            $this->handler->setToken($oauth_token, $request_token_secret);
            return $this->handler->getAccessToken($config['oauth'][static::NETWORK]['accesstokenurl']);
        }
        catch(\OAuthException $e)
        {
            Output::error('OauthException getting access token from ' . static::NETWORK .
                ' Error code : ' . $e->getCode() .
                '; Message: ' . $e->getMessage(),
                $config['oauth']['log']
            );

            return FALSE;
        }
    }

}

?>
