<?php

/**
 * This file contains an OAuth Connection Class
 * for Twitter.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

use Lunr\Core\Output;

/**
 * Twitter OAuth Connection Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 */
class TwitterConnection extends OAuthConnection
{

    /**
     * Name of the OAuth Service to connect to.
     * @var String
     */
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
     * Get user profile info from Twitter.
     *
     * @param String $access_token        OAuth token
     * @param String $access_token_secret Request token secret
     *
     * @return Array Array containing the user profile information, FALSE otherwise
     */
    public function get_user_info($access_token, $access_token_secret = '')
    {
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;

        if(!$this->handler->setAuthType(OAUTH_AUTH_TYPE_AUTHORIZATION))
        {
            return FALSE;
        }

        if(!$this->handler->setToken($access_token, $access_token_secret))
        {
            return FALSE;
        }

        try
        {
            $this->handler->fetch($config['oauth'][static::NETWORK]['verify_url']);
        }
        catch (\OAuthException $e)
        {
            Output::error('OauthException retrieving user info from ' . static::NETWORK .
                ' Error code : ' . $e->getCode() .
                '; Message: ' . $e->getMessage(),
                $config['oauth']['log']
            );

            return FALSE;
        }
        $response = $this->handler->getLastResponse();
        if($response === FALSE)
        {
            return FALSE;
        }

        ///TODO: find a better way to do that
        $user_info = json_decode($response, TRUE);
        if(!$user_info)
        {
            return FALSE;
        }

        return $this->parse_twitter_profile($user_info);
    }

    /**
     * Post a message to Twitter.
     *
     * @param String        $access_token        OAuth token
     * @param SocialMessage $message             SocialMessage object already filled
     * @param String        $access_token_secret Access token secret
     *
     * @return Boolean TRUE if the post to Twitter was done properly FALSE otherwise.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '')
    {
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;

        if(!$this->handler->setAuthType(OAUTH_AUTH_TYPE_AUTHORIZATION))
        {
            return FALSE;
        }

        if(!$this->handler->setToken($access_token, $access_token_secret))
        {
            return FALSE;
        }

        try
        {
            $this->handler->fetch(
                $config['oauth'][static::NETWORK]['publish_url'],
                array('status' => $message->message),
                OAUTH_HTTP_METHOD_POST
            );

            $result = $this->handler->getLastResponseInfo();

            if ($result['http_code'] == '200')
            {
                return TRUE;
            }
            else
            {
                $this->errno  = $result['http_code'];
                $this->errmsg = 'Unknown response';
                return FALSE;
            }
        }
        catch (\OAuthException $e)
        {
            $this->errno = $e->getCode();

            Output::error('OauthException posting a message to ' . static::NETWORK .
                ' Error code : ' . $this->errno .
                '; Message: ' . $e->getMessage(),
                $config['oauth']['log']
            );

            if ($this->errno == '401')
            {
                $this->errmsg = 'Token expired or invalid';
            }
            elseif ($this->errno == '403')
            {
                $this->errmsg = 'Message duplicated';
            }
            else
            {
                $this->errmsg = 'Unknown error';
            }

            return FALSE;
        }
    }

    /**
     * Parse a Twitter profile array and returns a Social Profile.
     *
     * @param Array $user_info Array with the user information coming from Facebook
     *
     * @return SocialProfile Object containing the facebook profile info.
     */
    private function parse_twitter_profile($user_info)
    {
        $user_profile = new SocialProfile();

        foreach($user_info as $key => $field)
        {
            switch ($key)
            {
                case 'id':
                    $user_profile->id = $field;
                    break;
                case 'name':
                    $user_profile->given_name = $field;
                    break;
                default:
                    break;
            }
        }

        return $user_profile;
    }

}

?>
