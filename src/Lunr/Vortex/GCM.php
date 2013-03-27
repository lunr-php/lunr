<?php

/**
 * This file contains the class GCM which stands for Google Cloud Messaging
 * framework. This class allows to send push notifications to Android devices.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Vortex
 * @subpackage Libraries
 * @author     Jose Viso <jose@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex;

use Lunr\Network\Curl;

/**
 * Android (GCM) Push Notifications System Library
 *
 * @category   Libraries
 * @package    Vortex
 * @subpackage Libraries
 * @author     Jose Viso <jose@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class GCM
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
        include_once 'conf.gcm.inc.php';
        // default: no error
        $this->errmsg = '';

        // default: no ID
        $this->id = '';

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
     * Send Android push notification based on registration ID and authToken.
     *
     * @param String $registrationID    The registration ID retrieved from the app on the phone.
     * @param String $authToken         The authorization token, now the GCM API key.
     * @param String $notification_info An associative array which holds any information about
     *                                  the notification to be sent to the user (message, id etc)
     *
     * @return Boolean, TRUE on success and FALSE otherwise
     */
    public function send_android_push($registrationID, $authToken, $notification_info)
    {
        global $config;

        $headers      = array('Content-Type:application/json', 'Authorization:key=' . $authToken);
        $collapse_key = $config['gcm']['collapse_key'];

        $payload = array(
            'registration_ids' => array($registrationID),
            'collapse_key'     => $collapse_key,
            'data'             => $notification_info
        );

        $curl = new Curl();
        $curl->set_option('HEADER', TRUE);
        $curl->set_http_headers($headers);

        $returned_data   = $curl->simple_post($config['gcm']['google_send_url'], json_encode($payload));
        $this->http_code = $curl->http_code;

        if ($returned_data === FALSE)
        {
            if($this->http_code == 401)
            {
                $this->errmsg = 'Authorization token invalid';
            }
            elseif ($this->http_code == 400)
            {
                $this->errmsg = 'Bad request';
            }
            elseif($this->http_code == 503)
            {
                $this->errmsg = 'Server temporarily unavailable';
            }
            else
            {
                $this->errmsg = 'Error sending notification! Code: ' . $this->http_code . "\n";
            }
        }
        else
        {
            $result = substr($returned_data, $curl->info['header_size']);
            if(stripos($result, 'multicast_id') !== FALSE)
            {
                $decoded_result = json_decode($result);
                $this->id       = $decoded_result->multicast_id;

                unset($curl);
                return TRUE;
            }
            else
            {
                $result       = str_replace('Error=', '', $result);
                $this->errmsg = $result;
            }
        }

        unset($curl);
        return FALSE;
    }

}

?>
