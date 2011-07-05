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
    public function get_user_info($access_oauth_token, $access_token_secret = '')
    {
        global $config;

        $this->handler->setToken($access_oauth_token, $access_token_secret);
        try
        {
            $data = $this->handler->fetch($config['social']['twitter']['verify_url']);
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
        $response = $this->handler->getLastResponse();
        if($response === FALSE)
        {
            return FALSE;
        }
        else
        {
            $user_info = Json::decode($response);
            if(!$user_info)
            {
                return FALSE;
            }
        }
        return $this->parse_twitter_profile($user_info);
    }

    /**
     * Post a message to Twitter
     *
     * @param String $oauth_token         Oauth token
     * @param String $msg                 SocialMessage object already filled
     * @param String $access_token_secret Access token secret
     *
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE otherwise.
     */
    public function post_message($access_oauth_token, SocialMessage $msg, $access_token_secret = '')
    {
        global $config;

        if(!$this->handler->setAuthType(OAUTH_AUTH_TYPE_FORM))
        {
            return FALSE;
        }
        if(!$this->handler->setToken($access_oauth_token, $access_token_secret))
        {
            return FALSE;
        }
        try
        {
            $response = $this->handler->fetch(
                    $config['social']['twitter']['publish_url'],
                    array('status' => $msg->message)
                );
        } catch (OAuthException $e)
        {
            Output::error('OauthException posting a message to Twitter.' .
                            'Error code : ' . $e.getCode() .
                            '; Message: ' . $e.getMessage(),
                            $config['oauth']['log']
                );

            return FALSE;
        }
        return Json::decode($this->handler->getLastResponse());
    }

    /**
     * Parse a Twitter profile array and returns a Social Profile
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