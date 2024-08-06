<?php

/**
 * This file contains the FrontControllerTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\FrontController;
use Lunr\Halo\LunrBaseTest;

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
     * Instance of the tested class.
     * @var FrontController
     */
    protected FrontController $class;

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

        $this->class = new FrontController($this->request, $this->handler);

        parent::baseSetUp($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->request);
        unset($this->handler);

        parent::tearDown();
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
