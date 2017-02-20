<?php

/**
 * This file contains the MsgpackViewTest class.
 *
 * PHP Version 5.4
 *
 * @package   Lunr\Corona
 * @author    Patrick Valk <p.valk@m2mobi.com>
 * @copyright 2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\MsgpackView;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
abstract class MsgpackViewTest extends LunrBaseTest
{

    /**
     * Mock instance of the Request class.
     * @var \Lunr\Corona\RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var \Lunr\Corona\Response
     */
    protected $response;

    /**
     * Mock instance of the Configuration class.
     * @var \Lunr\Core\Configuration
     */
    protected $configuration;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->response      = $this->getMockBuilder('Lunr\Corona\Response')->getMock();
        $this->request       = $this->getMockBuilder('Lunr\Corona\RequestInterface')->getMock();
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->class      = new MsgpackView($this->request, $this->response, $this->configuration);
        $this->reflection = new ReflectionClass('Lunr\Corona\MsgpackView');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->request);
        unset($this->response);
        unset($this->configuration);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit Test Data Provider for non-integer error info values.
     *
     * @return array $info Array of non-integer error info values.
     */
    public function invalidErrorInfoProvider()
    {
        $info   = [];
        $info[] = [ 'string' ];
        $info[] = [ NULL ];
        $info[] = [ '404_1' ];
        $info[] = [ '404.1' ];

        return $info;
    }

}

?>
