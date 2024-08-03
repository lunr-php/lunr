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
use WpOrg\Requests\Exception\Http as RequestsExceptionHTTP;
use WpOrg\Requests\Session;

/**
 * Low level Contentful API methods for Spark
 */
class DeliveryApi extends Api
{

    /**
     * Content Delivery API URL.
     * @var string
     */
    protected const URL = 'https://cdn.contentful.com';

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
        catch (RequestsExceptionHTTP $e)
        {
            $context = [ 'message' => $result['message'], 'request' => $response->url, 'id' => $result['sys']['id'] ];
            $this->logger->warning('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

            $result['total'] = 0;
        }
        catch (RequestsException $e)
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
