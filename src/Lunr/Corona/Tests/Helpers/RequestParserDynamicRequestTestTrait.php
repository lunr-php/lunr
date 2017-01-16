<?php

/**
 * This file contains the RequestParserDynamicRequestTestTrait.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests\Helpers;

use Lunr\Corona\HttpMethod;

/**
 * This trait contains test methods to verify a PSR-3 compliant logger was passed correctly.
 */
trait RequestParserDynamicRequestTestTrait
{

    use RequestParserStaticRequestTestTrait;

    /**
     * Preparation work for the request tests.
     *
     * @param Boolean $controller Whether to set a controller value
     * @param Boolean $method     Whether to set a method value
     *
     * @return void
     */
    protected abstract function prepare_request_data_with_slashes($controller = TRUE, $method = TRUE);

    /**
     * Unit Test Data Provider for possible controller key names.
     *
     * @return array $base Array of controller key names
     */
    public abstract function controllerKeyNameProvider();

    /**
     * Unit Test Data Provider for possible method key names.
     *
     * @return array $base Array of method key names
     */
    public abstract function methodKeyNameProvider();

    /**
     * Unit Test Data Provider for possible parameter key names.
     *
     * @return array $base Array of parameter key names
     */
    public abstract function paramsKeyNameProvider();

    /**
     * Unit Test Data Provider for Device Useragent keys.
     *
     * @return array $keys Array of array keys.
     */
    public abstract function deviceUserAgentKeyProvider();

    /**
     * Test that parse_request() unsets request data in the AST.
     */
    public function testParseRequestSetsDefaultHttpAction()
    {
        $this->prepare_request_test('HTTP', '80');

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::GET, $request['action']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the useragent is stored correctly.
     */
    public function testRequestUserAgent()
    {
        $this->prepare_request_test('HTTP', '80', TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('useragent', $request);
        $this->assertEquals('UserAgent', $request['useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the device useragent is stored correctly.
     *
     * @param String $key Key for the device useragent string
     *
     * @dataProvider deviceUserAgentKeyProvider
     */
    public function testRequestDeviceUserAgent($key)
    {
        $this->prepare_request_test('HTTP', '80', TRUE, $key);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('device_useragent', $request);
        $this->assertEquals('Device UserAgent', $request['device_useragent']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     *
     * @param String $key Controller key name
     *
     * @dataProvider controllerKeyNameProvider
     */
    public function testRequestController($key)
    {
        $this->controller = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('thecontroller', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     *
     * @param String $key Method key name
     *
     * @dataProvider methodKeyNameProvider
     */
    public function testRequestMethod($key)
    {
        $this->method = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('themethod', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     *
     * @param String $key Parameter key name
     *
     * @dataProvider paramsKeyNameProvider
     */
    public function testRequestParams($key)
    {
        $this->params = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('params', $request);
        $this->assertInternalType('array', $request['params']);
        $this->assertCount(2, $request['params']);
        $this->assertEquals('parama', $request['params'][0]);
        $this->assertEquals('paramb', $request['params'][1]);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCall()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('thecontroller/themethod', $request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithControllerUndefined()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(FALSE, TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithMethodUndefined()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, FALSE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     *
     * @param String $key Controller key name
     *
     * @dataProvider controllerKeyNameProvider
     */
    public function testRequestControllerWithSlashes($key)
    {
        $this->controller = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('thecontroller', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     *
     * @param String $key Method key name
     *
     * @dataProvider methodKeyNameProvider
     */
    public function testRequestMethodWithSlashes($key)
    {
        $this->method = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('themethod', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     *
     * @param String $key Parameter key name
     *
     * @dataProvider paramsKeyNameProvider
     */
    public function testRequestParamsWithSlashes($key)
    {
        $this->params = $key;

        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('params', $request);
        $this->assertInternalType('array', $request['params']);
        $this->assertCount(2, $request['params']);
        $this->assertEquals('parama', $request['params'][0]);
        $this->assertEquals('paramb', $request['params'][1]);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestCallWithSlashes()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data_with_slashes(TRUE, TRUE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('thecontroller/themethod', $request['call']);

        $this->cleanup_request_test();
    }

}

?>
