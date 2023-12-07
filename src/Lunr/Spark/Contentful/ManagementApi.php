<?php

/**
 * This file contains low level API methods for Contentful.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Requests;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;

/**
 * Low level Contentful API methods for Spark
 */
class ManagementApi extends Api
{

    /**
     * Content Management API URL.
     * @var string
     */
    protected const URL = 'https://api.contentful.com';

    /**
     * Constructor.
     *
     * @param CacheItemPoolInterface $cache  Shared instance of the credentials cache
     * @param LoggerInterface        $logger Shared instance of a Logger class.
     * @param Session                $http   Shared instance of the Requests\Session class.
     */
    public function __construct($cache, $logger, $http)
    {
        parent::__construct($cache, $logger, $http);
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
        catch (RequestsException $e)
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
