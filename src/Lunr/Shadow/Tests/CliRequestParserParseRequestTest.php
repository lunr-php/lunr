<?php

/**
 * This file contains the CliRequestParserParseRequestTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

use Lunr\Corona\HttpMethod;
use Lunr\Corona\Tests\Helpers\RequestParserDynamicRequestTestTrait;
use Psr\Log\LogLevel;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseRequestTest extends CliRequestParserTestCase
{

    use RequestParserDynamicRequestTestTrait;

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
    protected function prepare_request_test($protocol = 'HTTP', $port = '80', $useragent = FALSE, $key = ''): void
    {
        if (!extension_loaded('uuid'))
        {
            $this->markTestSkipped('Extension uuid is required.');
        }

        $_SERVER['SCRIPT_FILENAME'] = '/full/path/to/index.php';

        $this->mockFunction('gethostname', fn() => 'Lunr');
        $this->mockFunction('uuid_create', fn() => '962161b2-7a01-41f3-84c6-3834ad001adf');

        if (($protocol == 'HTTPS' && $port == '443') || ($protocol == 'HTTP' && $port == '80'))
        {
            $url = strtolower($protocol) . '://www.domain.com/path/to/';
        }
        else
        {
            $url = strtolower($protocol) . '://www.domain.com:' . $port . '/path/to/';
        }

        if ($useragent === TRUE)
        {
            $property = $this->getReflectionProperty('ast');
            $ast      = $property->getValue($this->class);

            $ast['useragent'] = [ 'UserAgent' ];

            if ($key != '')
            {
                $ast[$key] = [ 'Device UserAgent' ];
            }

            $property->setValue($this->class, $ast);
        }

        $this->mockedCalls = [
            'default_application_path' => [ 'default_application_path', '/full/path/to/' ],
            'default_webpath'          => [ 'default_webpath', '/path/to/' ],
            'default_protocol'         => [ 'default_protocol', strtolower($protocol) ],
            'default_domain'           => [ 'default_domain', 'www.domain.com' ],
            'default_port'             => [ 'default_port', $port ],
            'default_url'              => [ 'default_url', $url ],
            'default_controller'       => [ 'default_controller', 'DefaultController' ],
            'default_method'           => [ 'default_method', 'default_method' ],
        ];
    }

    /**
     * Preparation work for the request tests.
     *
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     * @param bool $override   Whether to override default values or not
     *
     * @return void
     */
    protected function prepare_request_data($controller = TRUE, $method = TRUE, $override = FALSE): void
    {
        if ($override === FALSE)
        {
            return;
        }

        $property = $this->getReflectionProperty('ast');
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
     * @param bool $controller Whether to set a controller value
     * @param bool $method     Whether to set a method value
     *
     * @return void
     */
    protected function prepare_request_data_with_slashes($controller = TRUE, $method = TRUE): void
    {
        $property = $this->getReflectionProperty('ast');
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
    private function cleanup_request_test(): void
    {
        $this->unmockFunction('gethostname');
        $this->unmockFunction('uuid_create');
    }

    /**
     * Unit Test Data Provider for possible base_url values and parameters.
     *
     * @return array $base Array of base_url parameters and possible values
     */
    public function baseurlProvider(): array
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
    public function controllerKeyNameProvider(): array
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
    public function methodKeyNameProvider(): array
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
    public function paramsKeyNameProvider(): array
    {
        $value   = [];
        $value[] = [ 'param' ];
        $value[] = [ 'params' ];
        $value[] = [ 'p' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for possible verbosity key names.
     *
     * @return array $base Array of verbosity key names
     */
    public function verbosityProvider(): array
    {
        $value   = [];
        $value[] = [ 'v', 1, LogLevel::NOTICE ];
        $value[] = [ 'v', 2, LogLevel::INFO ];
        $value[] = [ 'v', 3, LogLevel::DEBUG ];
        $value[] = [ 'verbose', 1, LogLevel::NOTICE ];
        $value[] = [ 'verbose', 2, LogLevel::INFO ];
        $value[] = [ 'verbose', 3, LogLevel::DEBUG ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Device Useragent keys in $_SERVER.
     *
     * @return array $keys Array of array keys.
     */
    public function deviceUserAgentKeyProvider(): array
    {
        $keys   = [];
        $keys[] = [ 'device_useragent' ];
        $keys[] = [ 'device-useragent' ];

        return $keys;
    }

    /**
     * Test that parse_request() unsets request data in the AST.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestRemovesRequestDataFromAst(): void
    {
        $this->prepare_request_test('HTTP', '80');
        $this->prepare_request_data(TRUE, TRUE, TRUE);

        $this->class->parse_request();

        $ast = $this->getReflectionPropertyValue('ast');

        $this->assertIsArray($ast);
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
    public function testParseRequestSetsHttpMethodWithLongOption(): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $ast = $this->getReflectionPropertyValue('ast');

        $ast['action'] = [ 'POST' ];

        $this->setReflectionPropertyValue('ast', $ast);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::POST, $request['action']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets default http method.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestSetsHttpMethodWithShortOption(): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $ast = $this->getReflectionPropertyValue('ast');

        $ast['x'] = [ 'POST' ];

        $this->setReflectionPropertyValue('ast', $ast);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('action', $request);
        $this->assertEquals(HttpMethod::POST, $request['action']);

        $this->cleanup_request_test();
    }

    /**
     * Test that parse_request() sets default http method.
     *
     * @param string           $key    Verbosity key name
     * @param int              $amount Amount of verbosity parameters passed
     * @param Psr\Log\LogLevel $level  Parsed verbosity level
     *
     * @dataProvider verbosityProvider
     * @covers       Lunr\Shadow\CliRequestParser::parse_request
     */
    public function testParseRequestSetsVerbosityLevel($key, $amount, $level): void
    {
        $this->prepare_request_test();
        $this->prepare_request_data();

        $ast = $this->getReflectionPropertyValue('ast');

        $ast[$key] = [];

        for ($i = $amount; $i > 0; $i--)
        {
            $ast[$key][] = FALSE;
        }

        $this->setReflectionPropertyValue('ast', $ast);

        $request = $this->class->parse_request();

        $this->assertIsArray($request);
        $this->assertArrayHasKey('verbosity', $request);
        $this->assertEquals($level, $request['verbosity']);

        $this->cleanup_request_test();
    }

}

?>
