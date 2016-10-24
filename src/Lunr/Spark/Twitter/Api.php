<?php

/**
 * This file contains low level API methods for Twitter.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

use Requests_Exception;
use Requests_Exception_HTTP;

/**
 * Low level Facebook API methods for Spark
 */
abstract class Api
{

    /**
     * Shared instance of the CentralAuthenticationStore
     * @var \Lunr\Spark\CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        $this->cas    = $cas;
        $this->logger = $logger;
        $this->http   = $http;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->http);
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
     * @param String $url     API URL
     * @param Array  $headers Array of HTTP headers to send with the request
     * @param Array  $params  Array of parameters for the API request
     * @param String $method  Request method to use
     * @param Array  $options Array of config options for the request library
     *
     * @return Array $result Array of return values
     */
    protected function get_json_results($url, $headers = [], $params = [], $method = 'GET', $options = [])
    {
        // Use the system trust store
        $options['verify'] = TRUE;

        try
        {
            $response = $this->http->request($url, $headers, $params, strtoupper($method), $options);

            $result = json_decode($response->body, TRUE);

            $response->throw_for_status();
        }
        catch(Requests_Exception_HTTP $e)
        {
            $error   = $result['errors'][0];
            $context = [
                'message' => $error['message'],
                'code'    => $error['code'],
                'request' => $response->url
            ];

            $this->logger->warning('Twitter API Request ({request}) failed, ({code}): {message}', $context);

            $result = '';
        }
        catch (Requests_Exception $e)
        {
            $context = [
                'message' => $e->getMessage(),
                'request' => $url
            ];

            $this->logger->warning('Twitter API Request ({request}) failed: {message}', $context);

            $result = '';
        }

        unset($response);

        return $result;
    }

}

?>
