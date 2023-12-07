<?php

/**
 * This file contains low level Preview API methods for Contentful.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Session;

/**
 * Low level Contentful Preview API methods for Spark
 */
class PreviewApi extends DeliveryApi
{

    /**
     * Content Preview API URL.
     * @var string
     */
    protected const URL = 'https://preview.contentful.com';

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

}

?>
