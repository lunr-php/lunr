<?php

/**
 * This file contains the ControllerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains test methods for the Controller class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Controller
 */
abstract class ControllerTest extends LunrBaseTest
{

    /**
     * Mock instance of the response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of the request class.
     * @var Request
     */
    protected $request;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->response = $this->getMock('Lunr\Core\Response');
        $this->request  = $this->getMockBuilder('Lunr\Core\Request')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Core\Controller')
                            ->setConstructorArgs([$this->request, $this->response])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Core\Controller');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->response);
        unset($this->request);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
