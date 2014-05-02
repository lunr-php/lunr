<?php

/**
 * This file contains the RequestParserRequestTestTrait.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo;

/**
 * This trait contains test methods to verify a PSR-3 compliant logger was passed correctly.
 *
 * @category   Tests
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
trait RequestParserRequestTestTrait
{

    /**
     * Parameter key name for the controller.
     * @var String
     */
    protected $controller = 'controller';

    /**
     * Parameter key name for the method.
     * @var String
     */
    protected $method = 'method';

    /**
     * Parameter key name for the parameters.
     * @var String
     */
    protected $params = 'param';

    /**
     * Preparation work for the request tests.
     *
     * @param String $protocol Protocol name
     * @param String $port     Port number
     *
     * @return void
     */
    protected abstract function prepare_request_test($protocol = 'HTTP', $port = '80');

    /**
     * Preparation work for the request tests.
     *
     * @param Boolean $controller Whether to set a controller value
     * @param Boolean $method     Whether to set a method value
     * @param Boolean $override   Whether to override default values or not
     *
     * @return void
     */
    protected abstract function prepare_request_data($controller = TRUE, $method = TRUE, $override = FALSE);

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
     * Cleanup work for the request tests.
     *
     * @return void
     */
    protected abstract function cleanup_request_test();

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public abstract function baseurlProvider();

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
     * Test that the host is stored correctly.
     */
    public function testRequestHost()
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('host', $request);
        $this->assertEquals('Lunr', $request['host']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the sapi is stored correctly.
     */
    public function testRequestSapi()
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('sapi', $request);
        $this->assertEquals(PHP_SAPI, $request['sapi']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the base_path is constructed and stored correctly.
     */
    public function testRequestBasePath()
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('base_path', $request);
        $this->assertEquals('/path/to/', $request['base_path']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the domain is stored correctly.
     */
    public function testRequestDomain()
    {
        $this->prepare_request_test();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('domain', $request);
        $this->assertEquals('www.domain.com', $request['domain']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the port is stored correctly.
     *
     * @param String $protocol Protocol name
     * @param String $port     Expected port value
     *
     * @dataProvider baseurlProvider
     */
    public function testRequestPort($protocol, $port)
    {
        $this->prepare_request_test($protocol, $port);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('port', $request);
        $this->assertEquals($port, $request['port']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the protocol is constructed and stored correctly.
     *
     * @param String $protocol Protocol name
     * @param String $port     Expected port value
     * @param String $baseurl  The expected base_url value
     *
     * @dataProvider baseurlProvider
     */
    public function testRequestBaseUrl($protocol, $port, $baseurl)
    {
        $this->prepare_request_test($protocol, $port);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('base_url', $request);
        $this->assertEquals($baseurl, $request['base_url']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default controller value is stored correctly.
     */
    public function testRequestDefaultController()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('controller', $request);
        $this->assertEquals('DefaultController', $request['controller']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default method value is stored correctly.
     */
    public function testRequestDefaultMethod()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('method', $request);
        $this->assertEquals('default_method', $request['method']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default params value is stored correctly.
     */
    public function testRequestDefaultParams()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('params', $request);
        $this->assertArrayEmpty($request['params']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCall()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data();

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertEquals('DefaultController/default_method', $request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCallWithControllerUndefined()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(FALSE);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('call', $request);
        $this->assertNull($request['call']);

        $this->cleanup_request_test();
    }

    /**
     * Test that the default call value is stored correctly.
     */
    public function testRequestDefaultCallWithMethodUndefined()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, FALSE);

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
