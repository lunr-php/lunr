<?php

/**
 * Apple Push Notifications System Library
 * @author M2Mobi, Julio Foulquié, Heinz Wiesinger
 */
class APNS
{

    /**
     * APNS response codes
     * @var SplFixedArray
     */
    private $error;

    /**
     * Constructor
     */
    public function __construct()
    {
        require("conf.notifications.inc.php");
        $this->error = SplFixedArray(10);
        $this->error[0] = "UNDEFINED"; //SUCCESS?
        $this->error[1] = "PROCESSING ERROR";
        $this->error[2] = "MISSING DEVICE TOKEN";
        $this->error[3] = "MISSING TOPIC";
        $this->error[4] = "MISSING PAYLOAD";
        $this->error[5] = "INVALID TOKEN SIZE";
        $this->error[6] = "INVALID TOPIC SIZE";
        $this->error[7] = "INVALID PAYLOAD SIZE";
        $this->error[8] = "INVALID TOKEN";
        $this->error[9] = "UNKNOWN ERROR";
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
        stream_context_set_option($ctx, 'ssl', 'local_cert', $config['apns']['cert']);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $config['apns']['cert']['pass']);
        $fp = stream_socket_client($config['apns']['push'], $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        if(!$fp)
        {
            Output::error("Error while opening socket: $err\n\n", $config['apns']['log']);
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
            Output::error("Error while unserializing\n\n", $config['apns']['log']);
            return FALSE;
        }
//         $response = "";
//         while (!feof($fp))
//         {
//             $response .= fgets($fp, 6);
//         }
        if(!fclose($fp))
        {
            Output::error("Error while closing socket\n\n", $config['apns']['log']);
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
        Output::error("Notification sent: $json_payload \n\n", $config['apns']['log']);
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
        stream_context_set_option($ctx, 'ssl', 'local_cert', $config['apns']['cert']);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $config['apns']['cert']['pass']);

        echo "CONNECTING TO FEEDBACK APNS\t\t";
        $apns = stream_socket_client($config['apns']['feedback'], $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
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
        if ($response[1] < 0 && $response[1] > 8)
        {
            $response[1] = 9;
        }
        Output::error("Push notification '$response' rejected by APNS. Reason: " . $this->error[$response[1]], $config['apns']['log']);
    }
}

?>
