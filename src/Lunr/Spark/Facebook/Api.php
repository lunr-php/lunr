<?php

/**
 * This file contains low level API methods for Facebook.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook;

/**
 * Low level Facebook API methods for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Api
{

    /**
     * Shared instance of the CentralAuthenticationStore
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Shared instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Requested fields of the profile.
     * @var Array
     */
    protected $fields;

    /**
     * Facebook resource identifier
     * @var String
     */
    protected $id;

    /**
     * Returned data.
     * @var Array
     */
    protected $data;

    /**
     * Boolean flag whether an access token was used for the request.
     * @var Boolean
     */
    protected $used_access_token;

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param LoggerInterface            $logger Shared instance of a Logger class.
     * @param Curl                       $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        $this->cas    = $cas;
        $this->logger = $logger;
        $this->curl   = $curl;
        $this->id     = '';
        $this->fields = [];
        $this->data   = [];

        $this->used_access_token = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->curl);
        unset($this->id);
        unset($this->fields);
        unset($this->data);
        unset($this->used_access_token);
    }

    /**
     * Get access to shared credentials.
     *
     * @param String $key Credentials key
     *
     * @return mixed $return Value of the chosen key
     */
    public function __get($key)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
            case 'app_secret_proof':
            case 'access_token':
                return $this->cas->get('facebook', $key);
            default:
                return NULL;
        }
    }

    /**
     * Set shared credentials.
     *
     * @param String $key   Key name
     * @param String $value Value to set
     *
     * @return void
     */
    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'app_id':
            case 'app_secret':
                $this->cas->add('facebook', $key, $value);
                break;
            case 'access_token':
                $this->cas->add('facebook', $key, $value);
                $this->cas->add('facebook', 'app_secret_proof', hash_hmac('sha256', $value, $this->app_secret));
                break;
            default:
                break;
        }
    }

    /**
     * Set the resource ID.
     *
     * @param String $id Facebook resource ID
     *
     * @return void
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * Specify the user profile fields that should be retrieved.
     *
     * @param Array $fields Fields to retrieve
     *
     * @return void
     */
    public function set_fields($fields)
    {
        if (is_array($fields) === FALSE)
        {
            return;
        }

        $this->fields = $fields;
    }

    /**
     * Fetch and parse results as though they were a query string.
     *
     * @param String $url    API URL
     * @param Array  $params Array of parameters for the API request
     * @param String $method Request method to use, either 'get' or 'post'
     *
     * @return Array $parts Array of return values
     */
    protected function get_url_results($url, $params = [], $method = 'get')
    {
        $this->curl->set_option('CURLOPT_FAILONERROR', FALSE);

        if (strtolower($method) === 'get')
        {
            $response = $this->curl->get_request($url . '?' . http_build_query($params));
        }
        else
        {
            $response = $this->curl->post_request($url, $params);
        }

        $parts = NULL;

        if ($response->http_code !== 200)
        {
            $parts   = [];
            $message = json_decode($response->get_result(), TRUE);
            $error   = $message['error'];
            $context = [ 'message' => $error['message'], 'code' => $error['code'], 'type' => $error['type'], 'request' => $url ];
            $this->logger->error('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);
        }
        else
        {
            parse_str($response->get_result(), $parts);
        }

        unset($response);

        return $parts;
    }

    /**
     * Fetch and parse results as though they were a query string.
     *
     * @param String $url    API URL
     * @param Array  $params Array of parameters for the API request
     * @param String $method Request method to use, either 'get' or 'post'
     *
     * @return Array $parts Array of return values
     */
    protected function get_json_results($url, $params = [], $method = 'get')
    {
        $this->curl->set_option('CURLOPT_FAILONERROR', FALSE);

        if (strtolower($method) === 'get')
        {
            $response = $this->curl->get_request($url . '?' . http_build_query($params));
        }
        else
        {
            $response = $this->curl->post_request($url, $params);
        }

        $result = json_decode($response->get_result(), TRUE);

        if ($response->http_code !== 200)
        {
            $error   = $result['error'];
            $result  = [];
            $context = [ 'message' => $error['message'], 'code' => $error['code'], 'type' => $error['type'], 'request' => $url ];
            $this->logger->error('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);
        }

        unset($response);

        return $result;
    }

    /**
     * Fetch the resource information from Facebook.
     *
     * @param String $url    API URL
     * @param Array  $params Array of parameters for the API request
     *
     * @return void
     */
    protected function fetch_data($url, $params = [])
    {
        if ($this->access_token !== NULL)
        {
            $params['access_token']    = $this->access_token;
            $params['appsecret_proof'] = $this->app_secret_proof;

            $this->used_access_token = TRUE;
        }
        else
        {
            $this->used_access_token = FALSE;
        }

        if (empty($this->fields) === FALSE)
        {
            $params['fields'] = implode(',', $this->fields);
        }

        $this->data = $this->get_json_results($url, $params);
    }

}

?>
