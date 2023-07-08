<?php

/**
 * This file contains the RequestParserStaticRequestTestTrait.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests\Helpers;

use Lunr\Corona\HttpMethod;
use Psr\Log\LogLevel;

/**
 * This trait contains test methods to verify a PSR-3 compliant logger was passed correctly.
 */
trait RequestParserStaticRequestTestTrait
{

    /**
     * Parameter key name for the controller.
     * @var string
     */
    protected $controller = 'controller';

    /**
     * Parameter key name for the method.
     * @var string
     */
    protected $method = 'method';

    /**
     * Parameter key name for the parameters.
     * @var string
     */
    protected $params = 'param';

    protected $mocked_calls = [];

    /**
     * Preparation work for the request tests.
     *
     * @param string $protocol  Protocol name
     * @param string $port      Port number
     * @param bool   $useragent Whether to include useragent information or not
     * @param string $key       Device useragent key
     *
     * @return void
     */
    protected abstract function prepare_request_test($protocol = 'HTTP', $port = '80', $useragent = FALSE, $key = ''): void;

    /**
     * Preparation work for the request tests.
     *
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     * @param bool $override   Whether to override default values or not
     *
     * @return void
     */
    protected abstract function prepare_request_data($controller = TRUE, $method = TRUE, $override = FALSE): void;

    /**
     * Cleanup work for the request tests.
     *
     * @return void
     */
    protected abstract function cleanup_request_test(): void;

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public abstract function baseurlProvider(): array;

    /**
     * Test that parse_request() unsets request data in the AST.
     */
    public function testParseRequestSetsDefaultHttpAction(): void
    {
        $this->prepare_request_test('HTTP', '80');

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::GET, $request['action']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the host is stored correctly.
     */
    public function testRequestHost(): void
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('host', $request);
        $this->assertEquals('Lunr', $request['host']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the sapi is stored correctly.
     */
    public function testRequestSapi(): void
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('sapi', $request);
        $this->assertEquals(PHP_SAPI, $request['sapi']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the application_path is constructed and stored correctly.
     */
    public function testApplicationPath(): void
    {
        $this->prepare_request_test();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('application_path', $request);
        $this->assertEquals('/full/path/to/', $request['application_path']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the base_path is constructed and stored correctly.
     */
    public function testRequestBasePath(): void
    {
        $this->prepare_request_test();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('base_path', $request);
        $this->assertEquals('/path/to/', $request['base_path']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the domain is stored correctly.
     */
    public function testRequestDomain(): void
    {
        $this->prepare_request_test();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('domain', $request);
        $this->assertEquals('www.domain.com', $request['domain']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the port is stored correctly.
     *
     * @param string $protocol Protocol name
     * @param string $port     Expected port value
     *
     * @dataProvider baseurlProvider
     */
    public function testRequestPort($protocol, $port): void
    {
        $this->prepare_request_test($protocol, $port);

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('port', $request);
        $this->assertEquals($port, $request['port']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param string $protocol Protocol name
     * @param string $port     Expected port value
     * @param string $baseurl  The expected base_url value
     *
     * @dataProvider baseurlProvider
     */
    public function testRequestBaseUrl($protocol, $port, $baseurl): void
    {
        $this->prepare_request_test($protocol, $port);

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('base_url', $request);
        $this->assertEquals($baseurl, $request['base_url']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the useragent is stored correctly, when it is not present.
     */
    public function testRequestNoUserAgent(): void
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('useragent', $request);
        $this->assertNull($request['useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the device useragent is stored correctly, when it is not present.
     */
    public function testRequestNoDeviceUserAgent(): void
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('device_useragent', $request);
        $this->assertNull($request['device_useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the verbosity is stored correctly.
     */
    public function testRequestVerbosity(): void
    {
        $this->prepare_request_test('HTTP', '80', TRUE);

        $this->configuration->expects($this->exactly(8))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('verbosity', $request);
        $this->assertEquals(LogLevel::WARNING, $request['verbosity']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     */
    public function testRequestDefaultController(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('DefaultController', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     */
    public function testRequestDefaultMethod(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('default_method', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     */
    public function testRequestDefaultParams(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('params', $request);
        $this->assertArrayEmpty($request['params']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCall(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('DefaultController/default_method', $request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCallWithControllerUndefined(): void
    {
        $this->prepare_request_test('HTTP', '80');

        unset($this->mocked_calls['default_controller']);

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCallWithMethodUndefined(): void
    {
        $this->prepare_request_test('HTTP', '80');

        unset($this->mocked_calls['default_method']);

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that a request ID is calculated.
     */
    public function testRequestId(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, FALSE);

        $this->configuration->expects($this->atLeast(2))
                            ->method('offsetGet')
                            ->willReturnMap(array_values($this->mocked_calls));

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('id', $request);
        $this->assertEquals('962161b27a0141f384c63834ad001adf', $request['id']);

        $this->cleanup_request_test();
    }

}

?>
