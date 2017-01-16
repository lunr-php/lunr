<?php

/**
 * This file contains the CliRequestParserParseRequestTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Tests\Helpers\RequestParserDynamicRequestTestTrait;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseRequestTest extends CliRequestParserTest
{

    use RequestParserDynamicRequestTestTrait;

    /**
     * Runkit simulation code for getting the hostname.
     * @var string
     */
    const GET_HOSTNAME = 'return "Lunr";';

    /**
     * Preparation work for the request tests.
     *
     * @param String  $protocol  Protocol name
     * @param String  $port      Port number
     * @param Boolean $useragent Whether to include useragent information or not
     * @param String  $key       Device useragent key
     *
     * @return void
     */
    protected function prepare_request_test($protocol = 'HTTP', $port = '80', $useragent = FALSE, $key = '')
    {
        if (extension_loaded('runkit') === FALSE)
        {
            $this->markTestSkipped('Extension runkit is required.');
        }

        $_SERVER['SCRIPT_FILENAME'] = '/full/path/to/index.php';

        $this->mock_function('gethostname', self::GET_HOSTNAME);

        $this->configuration->expects($this->at(0))
                            ->method('offsetGet')
                            ->with($this->equalTo('default_webpath'))
                            ->will($this->returnValue('/path/to/'));

        $this->configuration->expects($this->at(1))
                            ->method('offsetGet')
                            ->with($this->equalTo('default_protocol'))
                            ->will($this->returnValue(strtolower($protocol)));

        $this->configuration->expects($this->at(2))
                            ->method('offsetGet')
                            ->with($this->equalTo('default_domain'))
                            ->will($this->returnValue('www.domain.com'));

        $this->configuration->expects($this->at(3))
                            ->method('offsetGet')
                            ->with($this->equalTo('default_port'))
                            ->will($this->returnValue($port));

        if (($protocol == 'HTTPS' && $port == '443') || ($protocol == 'HTTP' && $port == '80'))
        {
            $url = strtolower($protocol) . '://www.domain.com/path/to/';
        }
        else
        {
            $url = strtolower($protocol) . '://www.domain.com:' . $port . '/path/to/';
        }

        $this->configuration->expects($this->at(4))
                            ->method('offsetGet')
                            ->with($this->equalTo('default_url'))
                            ->will($this->returnValue($url));

        if ($useragent === TRUE)
        {
            $property = $this->get_accessible_reflection_property('ast');
            $ast      = $property->getValue($this->class);

            $ast['useragent'] = [ 'UserAgent' ];

            if ($key != '')
            {
                $ast[$key] = [ 'Device UserAgent' ];
            }

            $property->setValue($this->class, $ast);
        }
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
        if ($controller === TRUE)
        {
            $this->configuration->expects($this->at(5))
                                ->method('offsetGet')
                                ->with($this->equalTo('default_controller'))
                                ->will($this->returnValue('DefaultController'));
        }

        if ($method === TRUE)
        {
            $this->configuration->expects($this->at(6))
                                ->method('offsetGet')
                                ->with($this->equalTo('default_method'))
                                ->will($this->returnValue('default_method'));
        }

        if ($override === FALSE)
        {
            return;
        }

        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        if ($controller === TRUE)
        {
            $ast[$this->controller] = [ 'thecontroller' ];
        }

        if ($method === TRUE)
        {
            $ast[$this->method] = [ 'themethod' ];
        }

        $ast[$this->params] = [ 'parama', 'paramb' ];

        $property->setValue($this->class, $ast);
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
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        if ($controller === TRUE)
        {
            $ast[$this->controller] = [ '/thecontroller//' ];
        }

        if ($method === TRUE)
        {
            $ast[$this->method] = [ '/themethod/' ];
        }

        $ast[$this->params] = [ '/parama/', '//paramb/' ];

        $property->setValue($this->class, $ast);
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
        $value[] = [ 'c' ];

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
        $value[] = [ 'm' ];

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
        $value[] = [ 'params' ];
        $value[] = [ 'p' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Device Useragent keys in $_SERVER.
     *
     * @return array $keys Array of array keys.
     */
    public function deviceUserAgentKeyProvider()
    {
        $keys   = [];
        $keys[] = [ 'device_useragent' ];

        return $keys;
    }

    /**
     * Test that parse_request() unsets request data in the AST.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestRemovesRequestDataFromAst()
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $ast = $this->get_reflection_property_value('ast');

        $this->assertInternalType('array', $ast);
        $this->assertCount(6, $ast);
        $this->assertArrayNotHasKey('controller', $ast);
        $this->assertArrayNotHasKey('c', $ast);
        $this->assertArrayNotHasKey('method', $ast);
        $this->assertArrayNotHasKey('m', $ast);
        $this->assertArrayNotHasKey('params', $ast);
        $this->assertArrayNotHasKey('param', $ast);
        $this->assertArrayNotHasKey('p', $ast);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets default http method.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestSetsHttpMethodWithLongOption()
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $ast = $this->get_reflection_property_value('ast');

        $ast['action'] = [ 'POST' ];

        $this->set_reflection_property_value('ast', $ast);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::POST, $request['action']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets default http method.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestSetsHttpMethodWithShortOption()
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $ast = $this->get_reflection_property_value('ast');

        $ast['x'] = [ 'POST' ];

        $this->set_reflection_property_value('ast', $ast);

        $request = $this->class->parse_request();

        $this->assertInternalType('array', $request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::POST, $request['action']);

        $this->cleanup_request_test();
    }

}

?>
