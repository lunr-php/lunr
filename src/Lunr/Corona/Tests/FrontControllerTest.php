<?php

/**
 * This file contains the FrontControllerTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\FrontController;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FrontController class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\FrontController
 */
abstract class FrontControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the FrontController class.
     * @var FrontController
     */
    protected $class;

    /**
     * Reflection instance of the FrontController class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Mock instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of a FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->request = $this->getMock('Lunr\Corona\RequestInterface');

        $this->response = $this->getMock('Lunr\Corona\Response');

        $this->fao = $this->getMock('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface');

        $this->class = new FrontController($this->request, $this->response, $this->fao);

        $this->reflection = new ReflectionClass('Lunr\Corona\FrontController');
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
        unset($this->fao);
    }

    /**
     * Unit test data provider for invalid controller names.
     *
     * @return array $names Array of invalid names
     */
    public function invalidControllerNameProvider()
    {
        $names   = array();
        $names[] = array(NULL);
        $names[] = array(FALSE);
        $names[] = array(1);
        $names[] = array(1.1);
        $names[] = array('String');

        return $names;
    }

}

?>
