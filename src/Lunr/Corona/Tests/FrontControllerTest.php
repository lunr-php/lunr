<?php

/**
 * This file contains the FrontControllerTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\FrontController;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FrontController class.
 *
 * @covers     Lunr\Corona\FrontController
 */
abstract class FrontControllerTest extends LunrBaseTest
{

    /**
     * Mock instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

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
        $this->request = $this->getMockBuilder('Lunr\Corona\RequestInterface')->getMock();

        $this->fao = $this->getMockBuilder('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface')->getMock();

        $this->class = new FrontController($this->request, $this->fao);

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
        unset($this->fao);
    }

    /**
     * Unit test data provider for invalid controller names.
     *
     * @return array $names Array of invalid names
     */
    public function invalidControllerNameProvider()
    {
        $names   = [];
        $names[] = [NULL];
        $names[] = [FALSE];
        $names[] = [1];
        $names[] = [1.1];
        $names[] = ['String'];

        return $names;
    }

}

?>
