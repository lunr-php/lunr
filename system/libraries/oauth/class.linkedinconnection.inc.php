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
     * Get user profile info from LinkedIn.
     *
     * @param String $access_oauth_token  Oauth token
     * @param String $access_token_secret Request token secret
     *
     * @return Array Array containing the user profile information, FALSE otherwise
     */
    public function get_user_info($access_oauth_token, $access_token_secret)
    {
        $this->handler->setToken($access_oauth_token, $access_token_secret);

        try
        {
            $data = $this->handler->fetch(
                $config['social'][NETWORK]['own_profile_url'],
                NULL,
                OAUTH_HTTP_METHOD_GET
            );

            return $this->handler->getLastResponse();

        }
        catch(OAuthException $e)
        {
            Output::error('Oauth Exception retrieving user profile from ' . NETWORK .
                             'Error code : ' .$e.getCode() .
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
        return $this->handler->getAccessToken($config['social']['linkedin']['access_token_url']);
    }

    public function login()
    {

    }

    public function get_user_info()
    {

    }

    private function generate_linkedin_share_xml($message)
    {
        global $config;

        $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><share></share>");
        $xml->addChild('comment', $message->comment);
        $xml->addChild('content');
        $xml->addChild('visibility');

        $xml->content->addChild('title', $message->message);
        $xml->content->addChild('submitted-url', $message->url);
        $xml->content->addChild('submitted-image-url', $message->image_url);

        $xml->visibility->addChild('code', $config['social']['linkedin']['visibility']);

        return $xml;
    }

}

?>
