<?php

/**
* This file contains the class C2DM which stands for Android Push Notifications
* System. This class allows to send push notifications to Android devices.
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
 * Android Push Notifications System Library
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
     * @param String $source Text to identify the application, for login purpose
     * @param String $service Name of the Google service it's requesting authorization for
     *
     * @return String authToken, FALSE otherwise
     */
    public function get_auth_token($username, $password, $source='test', $service='ac2dm')
    {
        $url = 'https://www.google.com/accounts/ClientLogin';
        $post_fields = 'accountType=' . urlencode('HOSTED_OR_GOOGLE')
            . '&Email=' . urlencode($username)
            . '&Passwd=' . urlencode($password)
            . '&source=' . urlencode($source)
            . '&service=' . urlencode($service);

        $curl = new Curl();
        $curl->set_option('HEADER', TRUE);
        $response = $curl->simple_post($url, $post_fields);

        if (strpos($response, '200 OK') === false)
        {
            return FALSE;
        }

        // Look for the auth code
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
     * @param String $registrationID The registration ID retrieved from the app on the phone
     * @param String $authToken The authorization token
     * @param String $message The message that will be sent.
     *
     * @return mixed The message ID on success, FALSE otherwise
     */
    public function send_android_push($registrationID, $authToken, $message)
    {
        $url = 'https://android.apis.google.com/c2dm/send';
        $msgType = "important";

        $headers = array('Authorization: GoogleLogin auth=' . $authToken);
        $data = array(
                    'registration_id' => $registrationID,
                    'collapse_key' => $msgType,
                    'data.message' => $message
                );

        $curl = new Curl();
        $curl->set_option('HTTPHEADER', $headers);

        $returned_data = $curl->simple_post($url, $data);

        if ($returned_data === FALSE)
        {
            echo "FAILED posting to $url\n\n";
            unset($curl);

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
