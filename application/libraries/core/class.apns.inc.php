<?php

/**
 * Apple Push Notifications System Library
 * @author M2Mobi, Julio Foulquié
 */
class Notifications
{

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
    * Send a push notification to device based on the given device token
    * @param String $device_id The device token which identifies the device
    * @param Array $payload The payload that'll be sent already formatted
    * @return Boolean, TRUE on success, FALSE otherwise
    */
    public function send_apple_push($device_id, $payload)
    {
        //      $device_id = 'cf1f3443 62f68843 fa928646 69c70f93 56472c57 b002f613 a9156965 6ca69def';

        //Payload format example:
        //WARNING: cannot be bigger than 256 bytes check before send!
        /*
          {
            "aps" : {
                "alert" : {
                    "body": "Message to be shown on the alert. NOT USE IF loc-key is set",
                    "action-loc-key": "LOCALIZED_RESOURCE_VIEW_BUTTON",
                    "loc-key" : "GAME_PLAY_REQUEST_FORMAT,
                    Key with the localized string on the bundle with the associated message",
                    "loc-args" : [
                        "Jenna",
                        "Frank",
                        "Array with the args for %@ substitutions on the localized string"
                    ] ,
                    "launch-image": "/path/to/the/image
                    The image is used as the launch image when users tap the action button or move the action slider. Just iOS4"
                },
                "badge" : 9,
                "sound" : "bingbong.aiff"
            },
            "foo1" : "bar1; possible information like flight number",
            "foo2" : "bar2; or notification ID, trip ID..."
        }
        *badge is the little red number on the app icon

        */
        global $JSON;

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $config['apns']['cert']['test'], 'passphrase', $config['apns']['cert']['test_pass']);
//         stream_context_set_option($ctx, 'ssl', 'local_cert', $config['apns']['cert']['live'], 'passphrase', $config['apns']['cert']['live_pass']);

        $fp = stream_socket_client($config['apns']['push']['test'], $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
//         $fp = stream_socket_client($config['apns']['push']['live'], $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        if(!$fp)
        {
            error_log(date('Y-m-d H:i') . " - Error while opening soket\n\n", 3, $config['apns']['log']);
            return FALSE;
        }



        $json_payload = json_encode($payload);
        //Simple notification format
//         $msg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $device_id)) . pack("n", strlen($json_payload)) . $json_payload;

        //Enhanced notification format
        $msg = chr(0) . pack("n", $identifier) . pack("n", $expiry_date) . pack("n", 32) . pack('H*', str_replace(' ', '', $device_id)) . pack("n", strlen($json_payload)) . $json_payload;

        if(!fwrite($fp, $msg))
        {
            error_log(date('Y-m-d H:i') . " - Error while unserializing\n\n", 3, $config['apns']['log']);
            return FALSE;
        }
        $response = "";
        while (!feof($fp))
        {
            $response .= fgets($fp, 6);
        }
        if(!fclose($fp))
        {
            error_log(date('Y-m-d H:i') . " - Error while closing socket\n\n", 3, $config['apns']['log']);
//             return FALSE;
        }
        if(!strlen($response))
        {
            echo "Response from Apple: ";
            var_dump($response);
            //TODO: Check this unpack
            $result[] = unpack("C1/n1status/N4identifier", $response);
            var_dump($result);
        }
        else
        {
            return TRUE;
        }

        if($result['status'] == 0)
        {
            return TRUE;
        }
        else
        {
            $this->process_apple_error($response);
        }
    }

    /**
    * Get a list with the devices that have no longer the application installed so
    * we shouldn't keep sending them push notifications. Otherwise Steve Jobs
    * will become angry and will rape your family and kill your pets!!!
    * @param String $device_id The device token which identifies the device
    * @param Array $payload The payload that'll be sent already formatted
    * @return Boolean, TRUE on success, FALSE otherwise
    */
    public function get_apple_feedback()
    {
        //connect to the APNS feedback servers
        //make sure you're using the right dev/production server & cert combo!
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
//         stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem', 'passphrase', $pass);
        echo "CONNECTING TO FEEDBACK APNS\t\t";
        $apns = stream_socket_client($config['apns']['feedback']['test'], $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx );
//         $apns = stream_socket_client($config['apns']['feedback']['live'], $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx );
        if (!$apns)
        {
            echo "[FAIL]\nError $errcode: $errstr\n";
            return FALSE;
        } else
        {
            echo "[OK]\n";
        }

        $feedback_tokens = array ();
        //and read the data on the connection:
        while ( ! feof ( $apns ) ) {
            $data = fread ( $apns, 38 );
            if (strlen ( $data )) {
                $feedback_tokens [] = unpack ( "N1timestamp/n1length/H*devtoken", $data );
            }
        }
        fclose($apns);

        var_dump ( $feedback_tokens );
    }

    /**
    * Reads the response from APNS and logs the error accordingly
    * @param String $response The response from APNS
    * @return void
    */
    public function process_apple_error($response)
    {
        switch($response[1])
        {
            case 1:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: PROCESSING ERROR\n\n", 3, $config['apns']['log']);
                break;
            case 2:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING DEVICE TOKEN\n\n", 3, $config['apns']['log']);
                break;
            case 3:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING TOPIC\n\n", 3, $config['apns']['log']);
                break;
            case 4:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING PAYLOAD\n\n", 3, $config['apns']['log']);
                break;
            case 5:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOKEN SIZE\n\n", 3, $config['apns']['log']);
                break;
            case 6:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOPIC SIZE\n\n", 3, $config['apns']['log']);
                break;
            case 7:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID PAYLOAD SIZE\n\n", 3, $config['apns']['log']);
                break;
            case 8:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOKEN\n\n", 3, $config['apns']['log']);
                break;
            default:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: UNKNOWN ERROR\n\n", 3, $config['apns']['log']);
                break;
        }
    }


?>