<?php

/**
 * This file contains the RequestResultHandlerTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestResultHandler;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the RequestResultHandlerTrait class.
 *
 * @covers     Lunr\Corona\RequestResultHandlerTrait
 */
abstract class RequestResultHandlerTest extends LunrBaseTest
{

    /**
     * Mock instance of the Request class.
     * @var \Lunr\Corona\Request
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var \Lunr\Corona\Response
     */
    protected $response;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
                             ->getMock();

        $this->class = new RequestResultHandler($this->request, $this->response, $this->logger);

        $this->reflection = new ReflectionClass($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->request);
        unset($this->response);
        unset($this->logger);
    }

    /**
     * Unit test data provider for invalid controller names.
     *
     * @return array $names Array of invalid names
     */
    public function invalidControllerNameProvider(): array
    {
        $names   = [];
        $names[] = [ NULL ];
        $names[] = [ FALSE ];
        $names[] = [ 1 ];
        $names[] = [ 1.1 ];

        return $names;
    }

}

?>
