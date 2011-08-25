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
namespace Lunr\Libraries\OAuth;
use Lunr\Libraries\OAuth\OAuthConnection;
use Lunr\Libraries\OAuth\SocialProfile;

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

        $this->handler->setToken($access_token, $access_token_secret);
        try
        {
            $this->handler->fetch($config['oauth'][static::NETWORK]['verify_url']);
        }
        catch (OAuthException $e)
        {
            Output::error('OauthException retrieving user info from ' . static::NETWORK .
                ' Error code : ' . $e.getCode() .
                '; Message: ' . $e.getMessage(),
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
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE otherwise.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '')
    {
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;

        if(!$this->handler->setAuthType(OAUTH_AUTH_TYPE_FORM))
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
                array('status' => $message->message)
            );
        }
        catch (OAuthException $e)
        {
            Output::error('OauthException posting a message to ' . static::NETWORK .
                ' Error code : ' . $e.getCode() .
                '; Message: ' . $e.getMessage(),
                $config['oauth']['log']
            );

            return FALSE;
        }

        ///TODO: find a better way to do that
        return json_decode($this->handler->getLastResponse(), TRUE);
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

        foreach($user_info as $key=>$field)
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