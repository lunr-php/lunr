<?php

/**
 * This file contains the JsonViewTest class.
 *
 * PHP Version 5.4
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\JsonView;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JsonView class.
 *
 * @category   Library
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\JsonView
 */
abstract class JsonViewTest extends LunrBaseTest
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
        $this->response      = $this->getMock('Lunr\Corona\Response');
        $this->request       = $this->getMock('Lunr\Corona\RequestInterface');
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->class      = new JsonView($this->request, $this->response, $this->configuration);
        $this->reflection = new ReflectionClass('Lunr\Corona\JsonView');
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
