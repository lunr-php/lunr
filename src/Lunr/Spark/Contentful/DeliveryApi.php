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
class DeliveryApi extends Api
{

    /**
     * Content Delivery API URL.
     * @var String
     */
    const URL = 'https://cdn.contentful.com';

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        parent::__construct($cas, $logger, $http);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
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

        $url = $this->get_base_url() . '/entries';

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

        $url = $this->get_base_url() . '/assets';

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
