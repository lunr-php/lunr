<?php

/**
 * This file contains low level API methods for Contentful.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful;

/**
 * Low level Contentful API methods for Spark
 */
class DeliveryApi
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
     * @param \Lunr\Network\Curl                     $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        $this->cas    = $cas;
        $this->logger = $logger;
        $this->curl   = $curl;
        $this->space  = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cas);
        unset($this->logger);
        unset($this->curl);
        unset($this->space);
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
            case 'access_token':
                return $this->cas->get('contentful', $key);
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
     * @param String $space_id Content space ID
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
     * @param String $type    Content type
     * @param Array  $filters Content filters
     *
     * @return Array $values Content Array
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
     * @param Array $filters Assets filters
     *
     * @return Array $values Content Array
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
     * @param String $url    API URL
     * @param Array  $params Array of parameters for the API request
     *
     * @return Array $parts Array of return values
     */
    protected function get_json_results($url, $params = [])
    {
        $this->curl->set_option('CURLOPT_FAILONERROR', FALSE);

        $response = $this->curl->get_request($url . '?' . http_build_query($params));

        $result = json_decode($response->get_result(), TRUE);

        if ($response->http_code !== 200)
        {
            $context = [ 'message' => $result['message'], 'request' => $url, 'id' => $result['sys']['id'] ];
            $this->logger->warning('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

            $result['total'] = 0;
        }

        unset($response);

        return $result;
    }

}

?>
