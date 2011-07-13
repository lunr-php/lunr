<?php

namespace Lunr\Libraries\Core;

use Lunr\Libraries\Core\Curl;

class C2DM
{

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    private function get_auth_token($username, $password, $source="test", $service="ac2dm")
    {
        //session_start();
        //if( isset($_SESSION['google_auth_id']) && $_SESSION['google_auth_id'] != null)
        //{
        //    return $_SESSION['google_auth_id'];
        //}

        $url = "https://www.google.com/accounts/ClientLogin";

        $post_fields = "accountType=" . urlencode('HOSTED_OR_GOOGLE')
            . "&Email=" . urlencode($username)
            . "&Passwd=" . urlencode($password)
            . "&source=" . urlencode($source)
            . "&service=" . urlencode($service);


        //curl_setopt($ch, CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // for debugging the request
        //curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debugging the request

        //$response = curl_exec($ch);

        //var_dump(curl_getinfo($ch)); //for debugging the request
        //var_dump($response);

        $curl = new Curl();

        $response = $curl->simple_post($url, $post_fields);

        if (strpos($response, '200 OK') === false)
        {
            return false;
        }

        // find the auth code
        preg_match("/(Auth=)([\w|-]+)/", $response, $matches);

        if (!$matches[2])
        {
            return false;
        }

        //$_SESSION['google_auth_id'] = $matches[2];
        return $matches[2];

    }

    public function send_android_push($registrationID, $authToken, $message)
    {
        # C2DM server URL
        $url = "https://android.apis.google.com/c2dm/send";

        $message = "Test Android PUSH notification";
        $msgtype = "important";

        //$authToken = get_auth_token('userTest','passTest');

        $headers = array('Authorization: GoogleLogin auth=' . $authToken);

        $data = array(
        	'registration_id' => $registrationID,
        	'collapse_key' => $msgType,
        	'data.message' => $message
            );

        $curl = new Curl();

        $curl->set_option('HTTPHEADER', $headers);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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
