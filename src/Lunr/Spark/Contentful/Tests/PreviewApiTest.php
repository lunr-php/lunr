<?php

/**
 * This file contains the PreviewApiTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\Contentful\PreviewApi;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the PreviewApi.
 *
 * @covers Lunr\Spark\Contentful\PreviewApi
 */
abstract class PreviewApiTest extends LunrBaseTest
{

    /**
     * Mock instance of the CentralAuthenticationStore class.
     * @var CentralAuthenticationStore
     */
    protected $cas;

    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Mock instance of the Logger class
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->cas      = $this->getMock('Lunr\Spark\CentralAuthenticationStore');
        $this->http     = $this->getMock('Requests_Session');
        $this->logger   = $this->getMock('Psr\Log\LoggerInterface');
        $this->response = $this->getMock('Requests_Response');

        $this->class = new PreviewApi($this->cas, $this->logger, $this->http);

        $this->reflection = new ReflectionClass('Lunr\Spark\Contentful\PreviewApi');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->cas);
        unset($this->http);
        unset($this->logger);
        unset($this->response);
    }

}

?>
