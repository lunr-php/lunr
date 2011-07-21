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
     * Constructor.
     */
    public function __construct()
    {
        global $config;
        include_once 'conf.c2dm.inc.php';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {

    }

    /**
     * Get authorization token.
     *
     * @param String $username User's email address
     * @param String $password User's password
     * @param String $source   Text to identify the application, for login purpose
     * @param String $service  Name of the Google service it's requesting authorization for
     *
     * @return String authToken, FALSE otherwise
     */
    public function get_auth_token($username, $password, $source='', $service='ac2dm')
    {
        global $config;

        $post_fields = array();
        $post_fields['accountType'] = urlencode($config['c2dm']['account_type']);
        $post_fields['Email'] = urlencode($username);
        $post_fields['Passwd'] = urlencode($password);
        $post_fields['source'] = urlencode($source);
        $post_fields['service'] = urlencode($service);

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
     * @return mixed The message ID on success, 401 if the authorization token is invalid,
     *               503 if the server is temporarily unavailable and  FALSE otherwise
     */
    public function send_android_push($registrationID, $authToken, $message)
    {
        global $config;

        $header = 'Authorization: GoogleLogin auth=' . $authToken;
        $msgType = $config['c2dm']['msg_type'];

        $data = array(
                    'registration_id' => $registrationID,
                    'collapse_key' => $msgType,
                    'data.message' => $message
                );

        $curl = new Curl();
        $curl->set_option('HEADER', TRUE);
        $curl->set_http_header($header);

        $returned_data = $curl->simple_post($config['c2dm']['google_send_url'], $data);

        if ($returned_data === FALSE)
        {
            if($curl->http_code == 401)
            {
                return $curl->http_code;
            }
            if($curl->http_code == 503)
            {
                return $curl->http_code;
            }
            else
            {
                unset($curl);
                return FALSE;
            }

            return FALSE;
        }
        else
        {
            unset($curl);
            return $returned_data;
        }
    }

}

?>
