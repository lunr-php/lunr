<?php

/**
 * This file contains the ApiTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Spark\Contentful\Api;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Contentful\Api
 */
abstract class ApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the credentials cache.
     * @var CacheItemPoolInterface
     */
    protected $cache;

    /**
     * Shared instance of the cache item class.
     * @var CacheItemInterface
     */
    protected $item;

    /**
     * Mock instance of the Requests\Session class.
     * @var Session
     */
    protected $http;

    /**
     * Mock instance of the Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests\Response class.
     * @var Response
     */
    protected $response;

    /**
     * Instance of the tested class.
     * @var Api
     */
    protected Api $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->cache    = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $this->item     = $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $this->http     = $this->getMockBuilder('WpOrg\Requests\Session')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $this->class = new Api($this->cache, $this->logger, $this->http);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->item);
        unset($this->cache);
        unset($this->http);
        unset($this->logger);
        unset($this->response);

        parent::tearDown();
    }

    /**
     * Unit test data provider for general __get() __set() keys.
     *
     * @return array $keys Array of keys
     */
    public function generalKeyProvider(): array
    {
        $keys   = [];
        $keys[] = [ 'access_token' ];
        $keys[] = [ 'management_token' ];

        return $keys;
    }

    /**
     * Unit test data provider for get methods.
     *
     * @return array $methods Array of get methods
     */
    public function getMethodProvider(): array
    {
        $methods   = [];
        $methods[] = [ 'get' ];
        $methods[] = [ 'GET' ];

        return $methods;
    }

}

?>
