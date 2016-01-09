<?php

/**
 * This file contains the CompactJsonViewTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\CompactJsonView;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CompactJsonView class.
 *
 * @covers     Lunr\Corona\CompactJsonView
 */
abstract class CompactJsonViewTest extends LunrBaseTest
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

        $this->class      = new CompactJsonView($this->request, $this->response, $this->configuration);
        $this->reflection = new ReflectionClass('Lunr\Corona\CompactJsonView');
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
     * Unit Test Data Provider for data values.
     *
     * @return array $info Array of data values.
     */
    public function dataProvider()
    {
        $info   = [];
        $info[] = [ [ 'key1' => 'value', 'key2' => NULL ], [ 'key1' => 'value' ] ];
        $info[] = [ [ 'key1' => 'value', 'key2' => [ 'key1' => 'value', 'key2' => NULL ] ], [ 'key1' => 'value', 'key2' => [ 'key1' => 'value' ] ] ];

        return $info;
    }

}

?>
