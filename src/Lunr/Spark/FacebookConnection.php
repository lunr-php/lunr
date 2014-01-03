<?php

/**
 * This file contains an OAuth Connection Class
 * for Facebook.
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

use Lunr\Network\Curl;

/**
 * Facebook OAuth Connection Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
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
     * Strings for checking if the access token has expired
     * @var String
     */
    const EXPIRED = 'Session has expired';

    /**
     * Strings for checking if the access token is valid
     * @var String
     */
    const VALID = 'data';

    /**
     * Strings for checking if the user has changed his password
     * @var String
     */
    const PWD_CHANGED = 'changed the password';

    /**
     * Strings for checking if the user has deauthorized the application
     * @var String
     */
    const APP_NOT_AUTH = 'has not authorized application';

    /**
     * Strings for checking if the user has logged out (for the case where offline_access
     * wasn't requierd)
     * @var String
     */
    const LOGGED_OUT = 'The session is invalid because the user logged out.';

    /**
     * API access token
     * @var String
     */
    private $token;

    /**
     * Facebook error number (401 when token expired, another number otherwise)
     * @var Integer
     */
    private $errno;

    /**
     * Facebook error message
     * @var String
     */
    private $errmsg;

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
     * Get the "request token" from the Facebook.
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

        $url = $config['oauth'][static::NETWORK]['request_token_url']
            . '?client_id=' . $config['oauth']['facebook']['client_id']
            . '&redirect_uri=' . urlencode($callback)
            . '&state=' . $state
            . '&display=touch&scope=email,publish_stream';

        return array(
            'state' => $state,
            'url'   => $url
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

        $token_url = $config['oauth'][static::NETWORK]['access_token_url']
            . '?client_id=' . $config['oauth'][static::NETWORK]['client_id']
            . '&redirect_uri=' . urlencode($url_back)
            . '&client_secret=' . $config['oauth'][static::NETWORK]['app_secret']
            . '&code=' . $oauth_token;

        $curl     = new Curl();
        $result   = $curl->get_request($token_url);
        $response = $result->get_result();
        $params   = NULL;
        parse_str($response, $params);
        unset($curl);
        unset($result);
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

        $url = $config['oauth'][static::NETWORK]['verify_url'] . $access_token;

        $curl     = new Curl();
        $result   = $curl->get_request($url);
        $response = $result->get_result();

        if($response === FALSE)
        {
            return FALSE;
        }
        else
        {
            ///TODO: find a better way to do that
            $user_info = json_decode($response, TRUE);
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
     * @return Boolean TRUE if the post to Facebook was done properly FALSE otherwise.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '')
    {
        global $config;

        $curl   = new Curl();
        $params = array('access_token' => $access_token, 'message' => $message->message);

        $result   = $curl->post_request($config['oauth'][static::NETWORK]['publish_url'], $params);
        $response = $result->get_result();

        if (($response !== FALSE) && ($response !== NULL))
        {
            return TRUE;
        }
        elseif ($this->check_access_token_state($access_token) === 'expired')
        {
            $this->errno  = '401';
            $this->errmsg = 'Token expired';
            return FALSE;
        }
        else
        {
            # TODO: find a way to check if the posting fails for a duplicated message
            $this->errno  = $result->http_code;
            $this->errmsg = 'Unknown error';
            return FALSE;
        }
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

        foreach($user_info as $key => $field)
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
                    break;
                case 'email':
                    $user_profile->email = $field;
                    break;
                default:
                    break;
            }
        }

        return $user_profile;
    }

    /**
     * Check the state of the access token.
     *
     * @param String $access_token Access token to check status
     *
     * @return String 'expired' if the token has expired, 'pwd_changed' if the user has
     *                changed the account password, 'app_not_authorized' if the application
     *                has been deauthorized, 'user_logged_out' in case the token was
     *                requested without offline_access parameter and the user has logged
     *                out, 'valid' if the token is valid and 'other_error' otherwise.
     */
    private function check_access_token_state($access_token)
    {
        global $config;

        $url  = $config['oauth']['facebook']['publish_url'] . '?access_token=' . $access_token;
        $info = file_get_contents($url);

        if (strpos($info, self::EXPIRED) !== FALSE)
        {
            return 'expired';
        }
        elseif (strpos($info, self::PWD_CHANGED) !== FALSE)
        {
            return 'pwd_changed';
        }
        elseif (strpos($info, self::APP_NOT_AUTH) !== FALSE)
        {
            return 'app_not_authorized';
        }
        elseif (strpos($info, self::LOGGED_OUT) !== FALSE)
        {
            return 'user_logged_out';
        }
        elseif (strpos($info, self::VALID) !== FALSE)
        {
            return 'valid';
        }
        else
        {
            return 'other_error';
        }
    }

}

?>
