<?php

/**
 * This file contains low level API methods for Contentful.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful;

use Requests_Exception;
use Requests_Exception_HTTP;

/**
 * Low level Contentful API methods for Spark
 */
class DeliveryApi
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
     * Space ID
     * @var String
     */
    protected $space;

    /**
     * Content Delivery API URL.
     * @var String
     */
    const URL = 'https://cdn.contentful.com/spaces/';

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
        $this->space  = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->http);
        unset($this->space);
    }

    /**
     * Get access to shared credentials.
     *
     * @param string $key Credentials key
     *
     * @return mixed $return Value of the chosen key
     */
    public function __get($key)
    {
        switch ($key)
        {
            case 'access_token':
                return $this->cas->get('contentful', $key);
            default:
                return NULL;
        }
    }

    /**
     * Set shared credentials.
     *
     * @param string $key   Key name
     * @param string $value Value to set
     *
     * @return void
     */
    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'access_token':
                $this->cas->add('contentful', $key, $value);
                break;
            default:
                break;
        }
    }

    /**
     * Set contentful space ID.
     *
     * @param string $space_id Content space ID
     *
     * @return DeliveryApi $self Self Reference
     */
    public function set_space_id($space_id)
    {
        $this->space = $space_id;

        return $this;
    }

    /**
     * Fetch entries from Contentful.
     *
     * @param string $type    Content type
     * @param array  $filters Content filters
     *
     * @return array $values Content Array
     */
    public function get_entries($type, $filters = [])
    {
        $filters['access_token'] = $this->access_token;
        $filters['content_type'] = $type;

        $url = static::URL . $this->space . '/entries';

        $values = $this->get_json_results($url, $filters);

        return $values;
    }

    /**
     * Fetch assets from Contentful.
     *
     * @param array $filters Assets filters
     *
     * @return array $values Content Array
     */
    public function get_assets($filters = [])
    {
        $filters['access_token'] = $this->access_token;

        $url = static::URL . $this->space . '/assets';

        $values = $this->get_json_results($url, $filters);

        return $values;
    }

    /**
     * Fetch and parse results as though they were a json string.
     *
     * @param string $url    API URL
     * @param array  $params Array of parameters for the API request
     *
     * @return array $parts Array of return values
     */
    protected function get_json_results($url, $params = [])
    {
        try
        {
            $response = $this->http->request($url, [], $params);

            $result = json_decode($response->body, TRUE);

            $response->throw_for_status();
        }
        catch (Requests_Exception_HTTP $e)
        {
            $context = [ 'message' => $result['message'], 'request' => $response->url, 'id' => $result['sys']['id'] ];
            $this->logger->warning('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

            $result['total'] = 0;
        }
        catch (Requests_Exception $e)
        {
            $context = [ 'message' => $e->getMessage(), 'request' => $url ];
            $this->logger->warning('Contentful API Request ({request}) failed! {message}', $context);

            $result['total'] = 0;
        }

        unset($response);

        return $result;
    }

}

?>
