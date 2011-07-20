<?php

/**
 * This file contains an OAuth Connection Class
 * for Facebook.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */

/**
 * Facebook OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class FacebookConnection implements OAuthConnectionInterface
{

    /**
     * Name of the OAuth Service to connect to.
     * @var String
     */
    const NETWORK = 'facebook';

    /**
     * API access token
     * @var String
     */
    private $token;

    /**
     * Constructor.
     *
     * @param String $token User access token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->token);
    }

    /**
     * Get the '' from the Facebook.
     *
     * @param String $callback URL to receive the callback from the OAuth provider
     *
     * @return Array Array containing the 'state' and the
     *              'url for Facebook' on success and FALSE otherwise
     */
    public function get_request_token($callback)
    {
        global $config;

        $state = md5(uniqid(rand(), TRUE));

        $url = $config['oauth'][NETWORK]['request_token_url']
            . '?client_id=' . $config['oauth']['facebook']['client_id']
            . '&redirect_uri=' . urlencode($callback)
            . '&state=' . $state
            . '&display=wap';

        return array(
            'state' => $state,
            'url' => $url
        );
    }

    /**
     * Get access token from Facebook.
     *
     * @param String $oauth_token Oauth token
     * @param String $url_back    URL to callback after a request
     *
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE on failure.
     */
    public function get_access_token($oauth_token, $url_back)
    {
        global $config;

        $token_url = $config['oauth'][NETWORK]['access_token_url']
            . '?client_id=' . $config['oauth'][NETWORK]['client_id']
            . '&redirect_uri=' . urlencode($url_back)
            . '&client_secret=' . $config['oauth'][NETWORK]['app_secret']
            . '&code=' . $oauth_token;

        $curl = new Curl();
        $response = $curl->simple_get($token_url);
        $params = NULL;
        parse_str($response, $params);
        unset($curl);
        return $params;
    }

    /**
     * Get user profile info from Facebook.
     *
     * @param String $access_token        OAuth token
     * @param String $access_token_secret Unused for Facebook
     *
     * @return Array Array containing the user profile information, FALSE otherwise
     */
    public function get_user_info($access_token, $access_token_secret = '')
    {
        global $config;

        $url = $config['oauth'][NETWORK]['verify_url'] . $access_token;
        $curl = new Curl();
        $response = $curl->simple_get($url);
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
        return $this->parse_facebook_profile($user_info);
    }

    /**
     * Post a message to Facebook.
     *
     * @param String        $access_token        OAuth token
     * @param SocialMessage $message             SocialMessage object already filled
     * @param String        $access_token_secret Unused for Facebook
     *
     * @return Array Array containing the 'oauth token' and the 'oauth token secret',
     *               FALSE otherwise.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '')
    {
        global $config;

        $curl = new Curl();
        $params = array('access_token' => $access_token, 'message' => $message->message);

        return $curl->simple_post($config['oauth'][NETWORK]['publish_url'], $params);
    }

    /**
     * Parse a Facebook profile array and returns a Social Profile.
     *
     * @param Array $user_info Array with the user information coming from Facebook
     *
     * @return SocialProfile Object containing the facebook profile info.
     */
    private function parse_facebook_profile($user_info)
    {
        $user_profile = new SocialProfile();

        foreach($user_info as $key=>$field)
        {
            switch ($key)
            {
                case 'id':
                    $user_profile->id = $field;
                    break;
                case 'first_name':
                    $user_profile->given_name = $field;
                    break;
                case 'last_name':
                    $user_profile->last_name = $field;
                    break;
                case 'gender':
                    $user_profile->gender = $field;
                case 'email':
                    $user_profile->email = $field;
                    break;
                default:
                    break;
            }
        }
        return $user_profile;
    }

}

?>