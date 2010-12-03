<?php

/**
 * Apple Push Notifications System Library
 * @author M2Mobi, Julio Foulquié
 */
class APNS
{

    /**
    * Whatever weird thing is this for, it saves a few strings of memory when notifications not used
    * @var config
    */
    private $config_notifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        require("conf.notifications.inc.php");
        $this->config_notifications =& $config;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
    * Send a push notification to device based on the given device token
    * @param String $device_token The device token which identifies the device
    * @param Array $payload The payload that'll be sent already formatted
    * @return Boolean, TRUE on success, FALSE otherwise
    */
    public function send_apple_push($device_token, $payload)
    {
        global $config, $JSON;

        $ctx = stream_context_create();
//       stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config_notifications['apns']['cert']['test']);
//        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->config_notifications['apns']['cert']['test_pass']);
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config_notifications['apns']['cert']['live']);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->config_notifications['apns']['cert']['live_pass']);
//        $fp = stream_socket_client($this->config_notifications['apns']['push']['test'], $err, $err_str, 60, STREAM_CLIENT_CONNECT, $ctx);
         $fp = stream_socket_client($this->config_notifications['apns']['push']['live'], $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        if(!$fp)
        {
            error_log(date('Y-m-d H:i') . " - Error while opening socket: $err $err_str\n\n", 3, $this->config_notifications['apns']['log']);
            return FALSE;
        }
        $json_payload = json_encode($payload);
//         $identifier = '0011';
//         $expiry_date = '';
        //Simple notification format
        $msg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $device_token)) . pack("n", strlen($json_payload)) . $json_payload;

        //Enhanced notification format
//         $msg = chr(0) . pack("n", $identifier) . pack("n", $expiry_date) . pack("n", 32) . pack('H*', str_replace(' ', '', $device_token)) . pack("n", strlen($json_payload)) . $json_payload;

        if(!fwrite($fp, $msg))
        {
            error_log(date('Y-m-d H:i') . " - Error while unserializing\n\n", 3, $this->config_notifications['apns']['log']);
            return FALSE;
        }
//         $response = "";
//         while (!feof($fp))
//         {
//             $response .= fgets($fp, 6);
//         }
        if(!fclose($fp))
        {
            error_log(date('Y-m-d H:i') . " - Error while closing socket\n\n", 3, $this->config_notifications['apns']['log']);
//             return FALSE;
        }
//         if(!strlen($res;ponse))
//         {
//             //TODO: Check this unpack
//             echo "Response from Apple: ";
//             var_dump($response);
//             $result[] = unpack("C1/n1status/N4identifier", $response);
// //             var_dump($result);
//         }
//         else
//         {
//             return TRUE;
//         }

//         if($result['status'] == 0)
//         {
//             return TRUE;
//         }
//         else
//         {
// //             $this->process_apple_error($response);
//             return FALSE;
//         }
        error_log(date('Y-m-d H:i') . " - Notification sent: $json_payload \n\n", 3, $this->config_notifications['apns']['log']);
        return TRUE;
    }

    /**
    * Get a list with the devices that have no longer the application installed so
    * we shouldn't keep sending them push notifications. Otherwise Steve Jobs
    * will become angry and will rape your family and kill your pets!!!
    * WARNING: NOT FINISHED (NEITHER USED) YET!
    * TODO: Add a cli function for removing the device ID of the users who uninstall the app
    * @return Array, An array with all the device tokens that should be removed
    */
    public function get_apple_feedback()
    {
        //connect to the APNS feedback servers
        //make sure you're using the right dev/production server & cert combo!
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config_notifications['apns']['cert']['test']);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->config_notifications['apns']['cert']['test_pass']);
//         stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config_notifications['apns']['cert']['live']);
//         stream_context_set_option($ctx, 'ssl', 'passphrase', $this->config_notifications['apns']['cert']['live_pass']);

        echo "CONNECTING TO FEEDBACK APNS\t\t";
        $apns = stream_socket_client($this->config_notifications['apns']['feedback']['test'], $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
//         $apns = stream_socket_client($this->config_notifications['apns']['feedback']['live'], $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx );
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
            if (strlen ( $data ))
            {
                $feedback_tokens[] = unpack("N1timestamp/n1length/H*devtoken", $data);
            }
        }
        fclose($apns);

        var_dump($feedback_tokens);
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
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: PROCESSING ERROR\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 2:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING DEVICE TOKEN\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 3:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING TOPIC\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 4:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: MISSING PAYLOAD\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 5:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOKEN SIZE\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 6:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOPIC SIZE\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 7:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID PAYLOAD SIZE\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            case 8:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: INVALID TOKEN\n\n", 3, $this->config_notifications['apns']['log']);
                break;
            default:
                error_log(date('Y-m-d H:i') . " - Push notification '$response' rejected by APNS. Reason: UNKNOWN ERROR\n\n", 3, $this->config_notifications['apns']['log']);
                break;
        }
    }
}

?>
