<?php

/**
 * This file contains an OAuth Connection Class
 * for Linkedin.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

use Lunr\Core\Output;

/**
 * Linkedin OAuth Connection Class
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Javier Negre <javi@m2mobi.com>
 * @author     Julio Foulquié <julio@m2mobi.com>
 */
class LinkedinConnection extends OAuthConnection
{

    /**
     * Name of the OAuth Service to connect to.
     * @var String
     */
    const NETWORK = 'linkedin';

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
                OAUTH_AUTH_TYPE_AUTHORIZATION
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
        parent::__destruct();
    }

    /**
     * Get user profile info from LinkedIn.
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

            $this->handler->fetch(
                $config['oauth'][static::NETWORK]['verify_url'],
                NULL,
                OAUTH_HTTP_METHOD_GET
            );
        }
        catch(\OAuthException $e)
        {
            Output::error('Oauth Exception retrieving user profile from ' . static::NETWORK .
                ' Error code : ' . $e->getCode() .
                '; Message: ' . $e->getMessage(),
                $config['oauth']['log']
            );

            return FALSE;
        }
        $response = $this->handler->getLastResponse();
        return $this->parse_linkedin_profile($response);
    }

    /**
     * Post a message to LinkedIn.
     *
     * @param String        $access_token        OAuth access token
     * @param SocialMessage $message             SocialMessage object already filled
     * @param String        $access_token_secret Access token secret
     *
     * @return Boolean TRUE if the post to Linkedin was done properly FALSE otherwise.
     */
    public function post_message($access_token, SocialMessage $message, $access_token_secret = '')
    {
        if(!$this->handler)
        {
            return FALSE;
        }

        global $config;
        $this->handler->setToken($access_token, $access_token_secret);

        $xml = $this->generate_linkedin_share_xml($message);

        try
        {
            $this->handler->fetch(
                $config['oauth'][static::NETWORK]['publish_url'],
                $xml->asXML(),
                OAUTH_HTTP_METHOD_POST,
                array('Content-Type' => 'text/xml')
            );

            $result = $this->handler->getLastResponseInfo();

            if ($result['http_code'] == '201')
            {
                return TRUE;
            }
        }
        catch(\OAuthException $e)
        {
            $this->errno = $e->getCode();
            $message     = $e->getMessage();

            Output::error('Oauth Exception posting a message to ' . static::NETWORK .
                ' Error code : ' . $this->errno .
                '; Message: ' . $message,
                $config['oauth']['log']
            );

            if ($this->errno == '401')
            {
                $this->errmsg = 'Token expired or invalid';
            }
            else
            {
                $this->errmsg = $message;
            }

            return FALSE;
        }
    }

    /**
     * Generate the XML needed to share a message on LinkedIn.
     *
     * @param String $message SocialMessage object already filled
     *
     * @return SimpleXMLElement SimpleXML object with the proper info
     */
    private function generate_linkedin_share_xml(SocialMessage $message)
    {
        global $config;

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><share></share>');
        $xml->addChild('comment', $message->comment);
        $xml->addChild('visibility');
        $xml->visibility->addChild('code', $config['oauth'][static::NETWORK]['visibility']);

        return $xml;
    }

    /**
     * Parse a LinkedIn profile object and returns a filled SocialProfile object.
     *
     * @param Array $user_info Array with the user information coming from Facebook
     *
     * @return SocialProfile Object containing the facebook profile info.
     */
    private function parse_linkedin_profile($user_info)
    {
        $xml_profile = new \SimpleXMLElement($user_info);

        $user_profile = new SocialProfile();

        foreach($xml_profile as $key => $field)
        {
            switch ($key)
            {
                case 'id':
                    $user_profile->id = (string)$xml_profile->$key;
                    break;
                case 'first-name':
                    $user_profile->given_name = (string)$xml_profile->$key;
                    break;
                case 'last-name':
                    $user_profile->last_name = (string)$xml_profile->$key;
                    break;
                default:
                    break;
            }
        }

        return $user_profile;
    }

}

?>
