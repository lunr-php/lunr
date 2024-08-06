<?php

/**
 * This file contains the CompactJsonViewTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\CompactJsonView;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTest;

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
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the Response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Instance of the tested class.
     * @var CompactJsonView
     */
    protected CompactJsonView $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->response      = $this->getMockBuilder('Lunr\Corona\Response')->getMock();
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new CompactJsonView($this->request, $this->response, $this->configuration);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->request);
        unset($this->response);
        unset($this->configuration);
        unset($this->class);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for data values.
     *
     * @return array $info Array of data values.
     */
    public function dataProvider(): array
    {
        $info   = [];
        $info[] = [ [ 'key1' => 'value', 'key2' => NULL ], [ 'key1' => 'value' ] ];
        $info[] = [ [ 'key1' => 'value', 'key2' => [ 'key1' => 'value', 'key2' => NULL ] ], [ 'key1' => 'value', 'key2' => [ 'key1' => 'value' ] ] ];

        return $info;
    }

}

?>
