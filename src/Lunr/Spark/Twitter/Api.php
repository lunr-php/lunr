<?php

/**
 * This file contains low level API methods for Twitter.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

/**
 * Low level Facebook API methods for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
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
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->curl);
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
            case 'consumer_key':
            case 'consumer_secret':
            case 'user_agent':
            case 'bearer_token':
                return $this->cas->get('twitter', $key);
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
            case 'consumer_key':
            case 'consumer_secret':
            case 'user_agent':
            case 'bearer_token':
                $this->cas->add('twitter', $key, $value);
                break;
            default:
                break;
        }
    }

    /**
     * Fetch and parse results as though they were a query string.
     *
     * @param String $url    API URL
     * @param Array  $params Array of parameters for the API request
     * @param String $method Request method to use, either 'get' or 'post'
     *
     * @return Array $result Array of return values
     */
    protected function get_json_results($url, $params = [], $method = 'get')
    {
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
            $error   = $result['errors'][0];
            $context = [ 'message' => $error['message'], 'code' => $error['code'], 'request' => $url ];
            $this->logger->error('Twitter API Request ({request}) failed, ({code}): {message}', $context);

            $result = '';
        }

        unset($response);

        return $result;
    }

}

?>
