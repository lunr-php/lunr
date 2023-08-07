<?php

/**
 * This file contains the RequestParserDynamicRequestTestTrait.
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
trait RequestParserDynamicRequestTestTrait
{

    use RequestParserStaticRequestTestTrait;

    /**
     * Preparation work for the request tests.
     *
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     *
     * @return void
     */
    abstract protected function prepare_request_data_with_slashes($controller = TRUE, $method = TRUE): void;

    /**
     * Unit Test Data Provider for possible controller key names.
     *
     * @return array $base Array of controller key names
     */
    abstract public function controllerKeyNameProvider(): array;

    /**
     * Unit Test Data Provider for possible method key names.
     *
     * @return array $base Array of method key names
     */
    abstract public function methodKeyNameProvider(): array;

    /**
     * Unit Test Data Provider for possible parameter key names.
     *
     * @return array $base Array of parameter key names
     */
    abstract public function paramsKeyNameProvider(): array;

    /**
     * Unit Test Data Provider for Device Useragent keys.
     *
     * @return array $keys Array of array keys.
     */
    abstract public function deviceUserAgentKeyProvider(): array;

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
     * Test that the useragent is stored correctly.
     */
    public function testRequestUserAgent(): void
    {
        $this->prepare_request_test('HTTP', '80', TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('useragent', $request);
        $this->assertEquals('UserAgent', $request['useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the device useragent is stored correctly.
     *
     * @param string $key Key for the device useragent string
     *
     * @dataProvider deviceUserAgentKeyProvider
     */
    public function testRequestDeviceUserAgent($key): void
    {
        $this->prepare_request_test('HTTP', '80', TRUE, $key);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('device_useragent', $request);
        $this->assertEquals('Device UserAgent', $request['device_useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the verbosity is stored correctly.
     */
    public function testRequestVerbosity(): void
    {
        $this->prepare_request_test('HTTP', '80', TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('verbosity', $request);
        $this->assertEquals(LogLevel::WARNING, $request['verbosity']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     *
     * @param string $key Controller key name
     *
     * @dataProvider controllerKeyNameProvider
     */
    public function testRequestController($key): void
    {
        $this->controller = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('thecontroller', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     *
     * @param string $key Method key name
     *
     * @dataProvider methodKeyNameProvider
     */
    public function testRequestMethod($key): void
    {
        $this->method = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('themethod', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     *
     * @param string $key Parameter key name
     *
     * @dataProvider paramsKeyNameProvider
     */
    public function testRequestParams($key): void
    {
        $this->params = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('params', $request);
        $this->assertIsArray($request['params']);
        $this->assertCount(2, $request['params']);
        $this->assertEquals('parama', $request['params'][0]);
        $this->assertEquals('paramb', $request['params'][1]);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCall(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('thecontroller/themethod', $request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithControllerUndefined(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(FALSE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithMethodUndefined(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, FALSE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     *
     * @param string $key Controller key name
     *
     * @dataProvider controllerKeyNameProvider
     */
    public function testRequestControllerWithSlashes($key): void
    {
        $this->controller = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('thecontroller', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     *
     * @param string $key Method key name
     *
     * @dataProvider methodKeyNameProvider
     */
    public function testRequestMethodWithSlashes($key): void
    {
        $this->method = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('themethod', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     *
     * @param string $key Parameter key name
     *
     * @dataProvider paramsKeyNameProvider
     */
    public function testRequestParamsWithSlashes($key): void
    {
        $this->params = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('params', $request);
        $this->assertIsArray($request['params']);
        $this->assertCount(2, $request['params']);
        $this->assertEquals('parama', $request['params'][0]);
        $this->assertEquals('paramb', $request['params'][1]);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithSlashes(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('thecontroller/themethod', $request['call']);

        $this->cleanup_request_test();
    }

}

?>
