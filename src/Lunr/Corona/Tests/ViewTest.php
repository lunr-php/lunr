<?php

/**
 * This file contains the ViewTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Core\Configuration;
use Lunr\Corona\Request;
use Lunr\Corona\Response;
use Lunr\Corona\View;
use Lunr\Halo\LunrBaseTest;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class tests the setup of the view class,
 * as well as the helper methods.
 *
 * @covers     Lunr\Corona\View
 */
abstract class ViewTest extends LunrBaseTest
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
     * Mock instance of the sub configuration class.
     * @var Configuration
     */
    protected $sub_configuration;

    /**
     * Instance of the tested class.
     * @var View&MockObject&Stub
     */
    protected View&MockObject&Stub $class;

    /**
     * TestCase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $this->configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [
            [ 'path', $this->sub_configuration ],
        ];

        $this->configuration->expects($this->any())
                      ->method('offsetGet')
                      ->willReturnMap($map);

        $this->request = $this->getMockBuilder('Lunr\Corona\Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->response = $this->getMockBuilder('Lunr\Corona\Response')->getMock();

        if (!headers_sent())
        {
            $this->request->expects($this->once())
                ->method('__get')
                ->with('id')
                ->willReturn('962161b27a0141f384c63834ad001adf');
        }

        $this->class = $this->getMockBuilder('Lunr\Corona\View')
                            ->setConstructorArgs(
                               [ $this->request, $this->response, $this->configuration ]
                             )
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
     * Unit Test Data Provider for baseurl values.
     *
     * @return array $values Set of test data.
     */
    public function baseUrlProvider(): array
    {
        $values   = [];
        $values[] = [ 'http://www.example.org/', 'method/param', 'http://www.example.org/method/param' ];
        $values[] = [ 'http://www.example.org/test/', 'method/param', 'http://www.example.org/test/method/param' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for statics values.
     *
     * @return array $values Set of test data.
     */
    public function staticsProvider(): array
    {
        $values   = [];
        $values[] = [ '/', 'statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/', '/statics', 'image/test.jpg', '/statics/image/test.jpg' ];
        $values[] = [ '/test/', 'statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        $values[] = [ '/test/', '/statics', 'image/test.jpg', '/test/statics/image/test.jpg' ];
        return $values;
    }

    /**
     * Unit Test Data Provider for fatal error information.
     *
     * @return array $values Array of mocked fatal error information.
     */
    public function fatalErrorInfoProvider(): array
    {
        $values   = [];
        $values[] = [ [ 'type' => 1, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 64, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 256, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

    /**
     * Unit Test Data Provider for error information.
     *
     * @return array $values Array of non-fatal error information.
     */
    public function errorInfoProvider(): array
    {
        $values   = [];
        $values[] = [ NULL ];
        $values[] = [ [ 'type' => 2, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 32, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 128, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 512, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 1024, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 2048, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 4096, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 8192, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];
        $values[] = [ [ 'type' => 16384, 'message' => 'Message', 'file' => 'index.php', 'line' => 2 ] ];

        return $values;
    }

}

?>
