<?php

/**
 * This file contains the RequestResultHandlerTest class.
 *
 * PHP Version 7.0
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
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = new RequestResultHandler($this->request, $this->response);

        $this->reflection = new ReflectionClass($this->class);

        $this->set_reflection_property_value('request', $this->request);
        $this->set_reflection_property_value('response', $this->response);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->request);
        unset($this->response);
    }

    /**
     * Unit test data provider for invalid controller names.
     *
     * @return array $names Array of invalid names
     */
    public function invalidControllerNameProvider()
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
