<?php

/**
 * This file contains the ControllerTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Controller class.
 *
 * @covers     Lunr\Corona\Controller
 */
abstract class ControllerTest extends LunrBaseTest
{

    /**
     * Mock instance of the response class.
     * @var \Lunr\Corona\Response
     */
    protected $response;

    /**
     * Mock instance of the request class.
     * @var \Lunr\Corona\Request
     */
    protected $request;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();
        $this->request  = $this->getMockBuilder('Lunr\Corona\Request')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Corona\Controller')
                            ->setConstructorArgs([ $this->request, $this->response ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Corona\Controller');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->response);
        unset($this->request);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
