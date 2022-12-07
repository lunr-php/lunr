<?php

/**
 * This file contains the FrontControllerTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @author    Andrea Nigido <andrea@m2mobi.com>
 * @copyright 2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
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
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the RequestResultHandler class.
     * @var RequestResultHandler
     */
    protected $handler;

    /**
     * Mock instance of a FilesystemAccessObject class.
     * @var \Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Test case constructor.
     */
    public function setUp(): void
    {
        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->handler = $this->getMockBuilder('Lunr\Corona\RequestResultHandler')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->fao = $this->getMockBuilder('Lunr\Gravity\Filesystem\FilesystemAccessObjectInterface')->getMock();

        $this->class = new FrontController($this->request, $this->handler, $this->fao);

        $this->reflection = new ReflectionClass('Lunr\Corona\FrontController');
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->request);
        unset($this->handler);
        unset($this->fao);
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

    /**
     * Unit test data provider for invalid controller names
     *
     * @return array $controller_names Array of invalid controller names
     */
    public function invalidControllerNameValuesProvider(): array
    {
        $controller_names   = [];
        $controller_names[] = [ 'test+test' ];
        $controller_names[] = [ 'test test' ];
        $controller_names[] = [ 'test\test' ];
        $controller_names[] = [ 'test/test' ];
        $controller_names[] = [ 'w00tw00t.at.blackhats.romanian.anti-sec:)controller' ];

        return $controller_names;
    }

}

?>
