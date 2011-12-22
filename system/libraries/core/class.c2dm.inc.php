<?php

/**
* This file contains the class C2DM which stands for Android Cloud To Device Messaging
* framework. This class allows to send push notifications to Android devices.
*
* PHP Version 5.3
*
* @category   Libraries
* @package    Core
* @subpackage Libraries
* @author     M2Mobi <info@m2mobi.com>
* @author     Jose Viso <jose@m2mobi.com>
*
*/

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\Curl;

/**
 * Android (C2DM) Push Notifications System Library
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 */
class C2DM
{

    /**
     * Id of sent push notification
     * @var String
     */
    private $id;

    /**
     * Curl error message
     * @var String
     */
    private $errmsg;

    /**
     * HTTP status code of the request made
     * @var Integer
     */
    private $http_code;

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $config;
        include_once 'conf.c2dm.inc.php';
        // default: no error
        $this->errmsg = '';

        // default: no ID
        $this->id   = '';

        // set http_code to zero to indicate we haven't made a request yet
        $this->http_code = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->errmsg);
        unset($this->id);
        unset($this->http_code);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to errmsg, id and http_code.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'errmsg':
            case 'id':
            case 'http_code':
                return $this->{$name};
                break;
            default:
                return NULL;
                break;
        }
    }

    /**
     * Get authorization token.
     *
     * @param String $username User's email address
     * @param String $password User's password
     * @param String $source   Text to identify the application, for login purpose
     *
     * @return String authToken, FALSE otherwise
     */
    public function get_auth_token($username, $password, $source='')
    {
        global $config;

        $post_fields                = array();
        $post_fields['accountType'] = urlencode($config['c2dm']['account_type']);
        $post_fields['Email']       = urlencode($username);
        $post_fields['Passwd']      = urlencode($password);
        $post_fields['source']      = urlencode($source);
        $post_fields['service']     = 'ac2dm';

        $curl = new Curl();
        $curl->set_option('HEADER', TRUE);
        $response = $curl->simple_post($config['c2dm']['request_token_url'], $post_fields);

        if (strpos($response, '200 OK') === FALSE)
        {
            return FALSE;
        }

        // Look for the authToken
        preg_match('/(Auth=)([\w|-]+)/', $response, $matches);

        if (!$matches[2])
        {
            unset($curl);
            return FALSE;
        }

        unset($curl);
        return $matches[2];
    }

    /**
     * Send Android push notification based on registration ID and authToken.
     *
     * @param String $registrationID The registration ID retrieved from the app on the phone.
     * @param String $authToken      The authorization token.
     * @param String $message        The message that will be sent.
     *
     * @return Boolean, TRUE on success and FALSE otherwise
     */
    public function send_android_push($registrationID, $authToken, $message)
    {
        global $config;

        $header  = 'Authorization: GoogleLogin auth=' . $authToken;
        $collapse_key = $config['c2dm']['collapse_key'];

        $data = array(
            'registration_id' => $registrationID,
            'collapse_key' => $collapse_key,
            'data.message' => $message
        );

        $curl = new Curl();
        $curl->set_option('HEADER', TRUE);
        $curl->set_http_header($header);

        $returned_data = $curl->simple_post($config['c2dm']['google_send_url'], $data);
        $this->http_code = $curl->http_code;

        if ($returned_data === FALSE)
        {
            if($curl->http_code == 401)
            {
                $this->errmsg = 'Authorization token invalid';
            }
            if($curl->http_code == 503)
            {
                $this->errmsg = 'Server temporarily unavailable';
            }
            else
            {
                $this->errmsg = 'Error sending notification';
            }

        }
        else
        {
            $result = substr($returned_data, $curl->info['header_size']);
            if(stripos($result, 'id') !== FALSE)
            {
                $result = str_replace('id=', '', $result);
                $this->id = $result;
                unset($curl);
                return TRUE;
            }
            else
            {
                $result = str_replace('Error=', '', $result);
                $this->errmsg = $result;
            }
        }
        unset($curl);
        return FALSE;
    }

}

?>
