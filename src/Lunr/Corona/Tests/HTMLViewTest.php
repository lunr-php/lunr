<?php

/**
 * This file contains the HTMLViewTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\HTMLView;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Halo\LunrBaseTest;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @covers     Lunr\Corona\HTMLView
 */
abstract class HTMLViewTest extends LunrBaseTest
{

    /**
     * Mock instance of the request class.
     * @var Request
     */
    protected $request;

    /**
     * Mock instance of the response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of the configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Instance of the tested class.
     * @var HTMLView&MockObject&Stub
     */
    protected HTMLView&MockObject&Stub $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        $this->class = $this->getMockBuilder('Lunr\Corona\HTMLView')
                           ->setConstructorArgs([ $this->request, $this->response, $this->configuration ])
                           ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->configuration);
        unset($this->request);
        unset($this->response);
        unset($this->class);

        parent::tearDown();
    }

    /**
     * Unit Test Data Provider for css alternating.
     *
     * @return array $values Set of test data.
     */
    public function cssAlternateProvider(): array
    {
        $values   = [];
        $values[] = [ 'row', 0, '', 'row_even' ];
        $values[] = [ 'row', 1, '', 'row_odd' ];
        $values[] = [ 'row', 0, 'custom', 'row_custom' ];
        return $values;
    }

}

?>
