<?php

/**
 * This file contains the WebRequestParserParseRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Halo\RequestParserRequestTestTrait;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseRequestTest extends WebRequestParserTest
{

    use RequestParserRequestTestTrait;

    /**
     * Runkit simulation code for getting the hostname.
     * @var string
     */
    const GET_HOSTNAME = 'return "Lunr";';

    /**
     * Preparation work for the request tests.
     *
     * @param String $protocol Protocol name
     * @param String $port     Port number
     *
     * @return void
     */
    protected function prepare_request_test($protocol = 'HTTP', $port = '80')
    {
        if (extension_loaded('runkit') === FALSE)
        {
            $this->markTestSkipped('Extension runkit is required.');
        }

        $this->mock_function('gethostname', self::GET_HOSTNAME);

        $_SERVER['SCRIPT_NAME'] = '/path/to/index.php';
        $_SERVER['HTTPS']       = $protocol === 'HTTPS' ? 'on' : 'off';
        $_SERVER['SERVER_NAME'] = 'www.domain.com';
        $_SERVER['SERVER_PORT'] = $port;
    }

    /**
     * Preparation work for the request tests.
     *
     * @param Boolean $controller Whether to set a controller value
     * @param Boolean $method     Whether to set a method value
     * @param Boolean $override   Whether to override default values or not
     *
     * @return void
     */
    protected function prepare_request_data($controller = TRUE, $method = TRUE, $override = FALSE)
    {
        $map = [];

        if ($controller === TRUE)
        {
            $map[] = [ 'default_controller', 'DefaultController' ];
        }

        if ($method === TRUE)
        {
            $map[] = [ 'default_method', 'default_method' ];
        }

        $this->configuration->expects($this->any())
                            ->method('offsetGet')
                            ->will($this->returnValueMap($map));

        if ($override === FALSE)
        {
            return;
        }

        if ($controller === TRUE)
        {
            $_GET[$this->controller] = 'thecontroller';
        }

        if ($method === TRUE)
        {
            $_GET[$this->method] = 'themethod';
        }

        $_GET[$this->params . '1'] = 'parama';
        $_GET[$this->params . '2'] = 'paramb';
        $_GET['data']   = 'value';
    }

    /**
     * Preparation work for the request tests.
     *
     * @param Boolean $controller Whether to set a controller value
     * @param Boolean $method     Whether to set a method value
     *
     * @return void
     */
    protected function prepare_request_data_with_slashes($controller = TRUE, $method = TRUE)
    {
        if ($controller === TRUE)
        {
            $_GET[$this->controller] = '/thecontroller//';
        }

        if ($method === TRUE)
        {
            $_GET[$this->method] = '/themethod/';
        }

        $_GET[$this->params . '1'] = '/parama/';
        $_GET[$this->params . '2'] = '//paramb/';
    }

    /**
     * Cleanup work for the request tests.
     *
     * @return void
     */
    private function cleanup_request_test()
    {
        $this->unmock_function('gethostname');
    }

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public function baseurlProvider()
    {
        $base   = [];
        $base[] = [ 'HTTPS', '443', 'https://www.domain.com/path/to/' ];
        $base[] = [ 'HTTPS', '80', 'https://www.domain.com:80/path/to/' ];
        $base[] = [ 'HTTP', '80', 'http://www.domain.com/path/to/' ];
        $base[] = [ 'HTTP', '443', 'http://www.domain.com:443/path/to/' ];

        return $base;
    }

    /**
     * Unit Test Data Provider for possible controller key names.
     *
     * @return array $base Array of controller key names
     */
    public function controllerKeyNameProvider()
    {
        $value   = [];
        $value[] = [ 'controller' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for possible method key names.
     *
     * @return array $base Array of method key names
     */
    public function methodKeyNameProvider()
    {
        $value   = [];
        $value[] = [ 'method' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for possible parameter key names.
     *
     * @return array $base Array of parameter key names
     */
    public function paramsKeyNameProvider()
    {
        $value   = [];
        $value[] = [ 'param' ];

        return $value;
    }

    /**
     * Test that parse_request() unsets request data in the $_GET super global variable.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestRemovesRequestDataFromGet()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $this->assertInternalType('array', $_GET);
        $this->assertCount(1, $_GET);
        $this->assertArrayHasKey('data', $_GET);
        $this->assertEquals('value', $_GET['data']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets $request_parsed to TRUE.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestSetsRequestParsedTrue()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $this->assertTrue($this->get_reflection_property_value('request_parsed'));

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() returns an ampty array if the data has already been parsed.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_request
     */
    public function testParseRequestReturnsEmptyArrayIfAlreadyParsed()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->set_reflection_property_value('request_parsed', TRUE);

        $this->assertArrayEmpty($this->class->parse_request());

        $this->cleanup_request_test();
    }

}

?>
