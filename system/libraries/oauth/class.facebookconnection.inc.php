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
 */

/**
 * Facebook OAuth Connection Class
 *
 * @category   Libraries
 * @package    OAuth
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class FacebookConnection implements OAuthConnectionInterface
{

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __destruct()
    {
        unset($this->token);
    }

    public function get_request_token($callback)
    {
        global $config;

        $state = md5(uniqid(rand(), TRUE));

        $url = $config['social']['facebook']['request_token_url']
            . '?client_id=' . $config['social']['facebook']['client_id']
            . '&redirect_uri=' . urlencode($callback)
            . '&state=' . $state
            . '&display=wap';

        return array(
                'state' => $state,
                'url' => $url
            );
    }

    public function get_access_token ($oauth_token, $request_token_secret)
    {
        global $config;

        $token_url = $config['social']['facebook']['access_token_url']
            . "?client_id=" . $config['social']['facebook']['client_id']
            . "&redirect_uri=" . urlencode($request_token_secret)
            . "&client_secret=" . $config['social']['facebook']['app_secret']
            . "&code=" . $oauth_token;

        $response = file_get_contents($token_url);
        $params = null;
        parse_str($response, $params);

        return $params;
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