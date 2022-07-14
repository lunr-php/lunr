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

use Requests;
use Requests_Exception;

/**
 * Low level Contentful API methods for Spark
 */
class ManagementApi extends Api
{

    /**
     * Content Management API URL.
     * @var String
     */
    protected const URL = 'https://api.contentful.com';

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
     * Create new entry
     *
     * @param string $type Content type
     * @param array  $data Entry data
     *
     * @return array $entry Entry
     */
    public function create_entry($type, $data)
    {
        return $this->get_json_results(
            $this->get_base_url() . '/entries',
            [ 'X-Contentful-Content-Type' => $type ],
            json_encode($data),
            Requests::POST
        );
    }

    /**
     * Retrieve an entry
     *
     * @param string $id Entry id
     *
     * @return array $entry Entry
     */
    public function get_entry($id)
    {
        return $this->get_json_results(
            $this->get_base_url() . '/entries/' . $id,
            [],
            [],
            Requests::GET
        );
    }

    /**
     * Update existing entry
     *
     * @param string $id              Entry id
     * @param string $current_version Entry current version
     * @param array  $data            Entry data
     *
     * @return array $entry Entry
     */
    public function update_entry($id, $current_version, $data)
    {
        return $this->get_json_results(
            $this->get_base_url() . '/entries/' . $id,
            [ 'X-Contentful-Version' => $current_version ],
            json_encode($data),
            Requests::PUT
        );
    }

    /**
     * Publish existing entry
     *
     * @param string $id              Entry id
     * @param string $current_version Entry current version
     *
     * @return array $entry Entry
     */
    public function publish_entry($id, $current_version)
    {
        return $this->get_json_results(
            $this->get_base_url() . '/entries/' . $id . '/published',
            [ 'X-Contentful-Version' => $current_version ],
            [],
            Requests::PUT
        );
    }

    /**
     * Unpublish existing entry
     *
     * @param string $id Entry id
     *
     * @return array $entry Entry
     */
    public function unpublish_entry($id)
    {
        return $this->get_json_results(
            $this->get_base_url() . '/entries/' . $id . '/published',
            [],
            [],
            Requests::DELETE
        );
    }

    /**
     * Fetch and parse results as though they were a json string.
     *
     * @param string $url     API URL
     * @param array  $headers Array of headers for the API request
     * @param array  $data    Data for the API request
     * @param string $method  HTTP method
     *
     * @return array $parts Array of return values
     */
    protected function get_json_results($url, $headers = [], $data = [], $method = Requests::GET)
    {
        try
        {
            $headers['Authorization'] = 'Bearer ' . $this->management_token;

            $response = $this->http->request($url, $headers, $data, $method);

            $result = json_decode($response->body, TRUE);

            $response->throw_for_status();
        }
        catch (Requests_Exception $e)
        {
            $context = [ 'message' => $e->getMessage(), 'request' => $url ];
            $this->logger->warning('Contentful API Request ({request}) failed: {message}', $context);

            throw $e;
        }

        unset($response);

        return $result;
    }

}

?>
