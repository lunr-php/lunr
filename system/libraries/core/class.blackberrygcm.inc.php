<?php

/**
 * This file contains the class GCM which stands for Google Cloud Messaging
 * framework. This class allows to send push notifications to Android devices.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Jose Viso <jose@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * Blackberry Android (GCM) Push Notifications System Library
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Jose Viso <jose@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class BlackBerryGCM
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
     * Error code of the request made
     * @var Integer
     */
    private $errorcode;

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $config;
        include_once 'conf.blackberrygcm.inc.php';
        // default: no error
        $this->errmsg = '';

        // default: no ID
        $this->id = '';

        // set http_code to zero to indicate we haven't made a request yet
        $this->errorcode = 0;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->errmsg);
        unset($this->id);
        unset($this->errorcode);
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
            case 'errorcode':
                return $this->{$name};
                break;
            default:
                return NULL;
                break;
        }
    }

    /**
     * Send Blackberry Android push notification based on registration ID and authToken.
     *
     * @param String $registrationID    The registration ID retrieved from the app on the phone.
     * @param String $authToken         The authorization token, now the BBGCM API key.
     * @param Array  $notification_info An associative array which holds any information about
     *                                  the notification to be sent to the user (message, id etc)
     *
     * @return Boolean, TRUE on success and FALSE otherwise
     */
    public function send_android_push($registrationID, $authToken, $notification_info)
    {
        global $config;

        $err = false;

        // Password provided by RIM
        $password = $config['blackberrygcm']['password'];

        // Deliver before timestamp
        $deliverbefore = gmdate('Y-m-d\TH:i:s\Z', strtotime('+5 minutes'));

        // Unique Push ID for request with RIM (unrelated to message id)
        $push_id = microtime(true);

        $str_xml = '';
        try
        {
            $xml = simplexml_load_string(file_get_contents($config['blackberrygcm']['xml_request_template']));

            $xml->{'push-message'}['push-id']                  = $push_id;
            $xml->{'push-message'}["deliver-before-timestamp"] = $deliverbefore;
            $xml->{'push-message'}["source-reference"]         = $authToken;
            $xml->{'push-message'}->address["address-value"]   = $registrationID;

            $str_xml = $xml->asXML();
        }
        catch (Exception $e)
        {
            Output::error("EXCEPTION: " . $e->getMessage());
            return FALSE;
        }

        $data = '--mPsbVQo0a68eIL3OAxnm'. "\r\n" .
                'Content-Type: application/xml; charset=UTF-8' . "\r\n\r\n" .
                $str_xml . "\r\n" .
                '--mPsbVQo0a68eIL3OAxnm' . "\r\n" .
                'Content-Type: text/plain' . "\r\n" .
                'Push-Message-ID: ' . $push_id . "\r\n\r\n" .
                json_encode($notification_info) .
                "\r\n" .
                '--mPsbVQo0a68eIL3OAxnm--' . "\n\r";

        // Create a new Curl resource
        $curl = new Curl();
        $curl->set_option('URL', $config['blackberrygcm']['google_send_url']);
        $curl->set_option('HEADER', FALSE);
        $curl->set_option('HTTP_VERSION', CURL_HTTP_VERSION_1_1);
        $curl->set_option('HTTPAUTH', CURLAUTH_BASIC);
        $curl->set_option('USERPWD', $authToken . ':' . $password);
        $curl->set_option('RETURNTRANSFER', TRUE);
        $curl->set_option('HTTPHEADER', array("Content-Type: multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml",
                                              "Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2",
                                              "Connection: keep-alive"));

        $xmldata = $curl->simple_post($config['blackberrygcm']['google_send_url'], $data);

        // Start parsing response into XML data that we can read and output
        $p = xml_parser_create();

        xml_parse_into_struct($p, $xmldata, $vals);

        $this->errorcode = xml_get_error_code($p);
        if ($this->errorcode > 0)
        {
            $this->errmsg = xml_error_string($this->errorcode);
            $err = true;
        }

        xml_parser_free($p);
        unset($curl);

        // Save the notification id
        $this->id = $notification_info['id'];

        return (!$err && $vals[1]['tag'] == 'PUSH-RESPONSE');
    }

}

?>
