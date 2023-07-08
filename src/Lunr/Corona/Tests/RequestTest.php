<?php

/**
 * This file contains the RequestTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Request;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DateTime class.
 *
 * @covers     Lunr\Corona\Request
 */
abstract class RequestTest extends LunrBaseTest
{

    /**
     * Mock of the Request Parser class.
     * @var \Lunr\Corona\RequestParserInterface
     */
    protected $parser;

    /**
     * Mocked file upload data.
     * @var array
     */
    protected $files = [
        'image' => [
            'name'     => 'Name',
            'type'     => 'Type',
            'tmp_name' => 'Tmp',
            'error'    => 'Error',
            'size'     => 'Size',
        ],
    ];

    /**
     * Shared TestCase Constructor code.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->parser = $this->getMockBuilder('Lunr\Corona\RequestParserInterface')->getMock();

        $this->parser->expects($this->once())
                     ->method('parse_request')
                     ->willReturn($this->get_request_values());

        $this->parser->expects($this->once())
                     ->method('parse_post')
                     ->willReturn([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ]);

        $this->parser->expects($this->once())
                     ->method('parse_get')
                     ->willReturn([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ]);

        $this->parser->expects($this->once())
                     ->method('parse_cookie')
                     ->willReturn([ 'cookie_key' => 'cookie_value' ]);

        $this->parser->expects($this->once())
                     ->method('parse_server')
                     ->willReturn([ 'server_key' => 'server_value', 'HTTP_SERVER_KEY' => 'HTTP_SERVER_VALUE' ]);

        $this->parser->expects($this->once())
                     ->method('parse_files')
                     ->willReturn($this->files);

        $this->parser->expects($this->once())
                     ->method('parse_command_line_arguments')
                     ->willReturn([]);

        $this->class      = new Request($this->parser);
        $this->reflection = new ReflectionClass('Lunr\Corona\Request');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->parser);
    }

    /**
     * Return sample request values.
     *
     * @return array $request Sample request values
     */
    protected function get_request_values(): array
    {
        $request = [
            'protocol'         => 'https',
            'domain'           => 'www.domain.com',
            'port'             => '443',
            'base_path'        => '/path/to/',
            'base_url'         => 'https://www.domain.com/path/to/',
            'sapi'             => 'cli',
            'controller'       => 'controller',
            'method'           => 'method',
            'params'           => [ 'param1', 'param2' ],
            'call'             => 'controller/method',
            'useragent'        => 'UserAgent',
            'device_useragent' => 'Device UserAgent',
            'id'               => '962161b27a0141f384c63834ad001adf',
            'bearer_token'     => '123456789',
        ];

        return $request;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestValueProvider(): array
    {
        $values = [];

        foreach ($this->get_request_values() as $key => $value)
        {
            $values[] = [ $key, $value ];
        }

        return $values;
    }

    /**
     * Unit test Data Provider for valid cli argument values.
     *
     * @return array $values Set of cli argument key value pair
     */
    public function validCliArgsValueProvider(): array
    {
        $values   = [];
        $values[] = [ [] ];
        $values[] = [ [ [ FALSE, FALSE ] ] ];
        $values[] = [ [ 'test' ] ];
        $values[] = [ [ 'test', 'test1' ] ];

        return $values;
    }

    /**
     * Unit Test Data provider for cli argument keys.
     *
     * @return array $values Set cli argument keys
     */
    public function cliArgsKeyProvider(): array
    {
        $values   = [];
        $values[] = [ [] ];
        $values[] = [ [ 'a' ] ];
        $values[] = [ [ 'a', 'b' ] ];

        return $values;
    }

    /**
     * Unit Test Data Provider for invalid mock values.
     *
     * @return array $cookie Set of invalid mock values
     */
    public function invalidMockValueProvider(): array
    {
        $values   = [];
        $values[] = [ new \stdClass() ];
        $values[] = [ 0 ];
        $values[] = [ 'String' ];
        $values[] = [ TRUE ];
        $values[] = [ NULL ];

        return $values;
    }

    /**
     * Unit Test Data Provider for unhandled __get() keys.
     *
     * @return array $keys Array of unhandled key values
     */
    public function unhandledMagicGetKeysProvider(): array
    {
        $keys   = [];
        $keys[] = [ 'Unhandled' ];

        return $keys;
    }

    /**
     * Unit Test Data Provider for Accept header content type(s).
     *
     * @return array $value Array of content type(s)
     */
    public function contentTypeProvider(): array
    {
        $value   = [];
        $value[] = [[ 'text/html' ]];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public function acceptLanguageProvider(): array
    {
        $value   = [];
        $value[] = [[ 'en-US' ]];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public function acceptCharsetProvider(): array
    {
        $value   = [];
        $value[] = [[ 'utf-8' ]];

        return $value;
    }

}

?>
