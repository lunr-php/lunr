<?php

/**
 * This file contains the RequestTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
     * @var Array
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
    public function setUp()
    {
        $this->parser = $this->getMockBuilder('Lunr\Corona\RequestParserInterface')->getMock();

        $this->parser->expects($this->once())
                     ->method('parse_request')
                     ->will($this->returnValue($this->get_request_values()));

        $this->parser->expects($this->once())
                     ->method('parse_post')
                     ->will($this->returnValue([ 'post_key' => 'post_value' ]));

        $this->parser->expects($this->once())
                     ->method('parse_get')
                     ->will($this->returnValue([ 'get_key' => 'get_value' ]));

        $this->parser->expects($this->once())
                     ->method('parse_cookie')
                     ->will($this->returnValue([ 'cookie_key' => 'cookie_value' ]));

        $this->parser->expects($this->once())
                     ->method('parse_server')
                     ->will($this->returnValue([ 'server_key' => 'server_value', 'HTTP_SERVER_KEY' => 'HTTP_SERVER_VALUE' ]));

        $this->parser->expects($this->once())
                     ->method('parse_files')
                     ->will($this->returnValue($this->files));

        $this->parser->expects($this->once())
                     ->method('parse_command_line_arguments')
                     ->will($this->returnValue([]));

        $this->class      = new Request($this->parser);
        $this->reflection = new ReflectionClass('Lunr\Corona\Request');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->parser);
    }

    /**
     * Return sample request values.
     *
     * @return Array $request Sample request values
     */
    protected function get_request_values()
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
        ];

        return $request;
    }

    /**
     * Unit Test Data Provider for request values.
     *
     * @return array $values Set of request values
     */
    public function requestValueProvider()
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
    public function validCliArgsValueProvider()
    {
        $values   = [];
        $values[] = [[]];
        $values[] = [[[ FALSE, FALSE ]]];
        $values[] = [[ 'test' ]];
        $values[] = [[ 'test', 'test1' ]];

        return $values;
    }

    /**
     * Unit Test Data provider for cli argument keys.
     *
     * @return array $values Set cli argument keys
     */
    public function cliArgsKeyProvider()
    {
        $values   = [];
        $values[] = [[]];
        $values[] = [[ 'a' ]];
        $values[] = [[ 'a', 'b' ]];

        return $values;
    }

    /**
     * Unit Test Data Provider for invalid mock values.
     *
     * @return array $cookie Set of invalid mock values
     */
    public function invalidMockValueProvider()
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
    public function unhandledMagicGetKeysProvider()
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
    public function contentTypeProvider()
    {
        $value   = [];
        $value[] = [ 'text/html' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header language(s).
     *
     * @return array $value Array of language(s)
     */
    public function acceptLanguageProvider()
    {
        $value   = [];
        $value[] = [ 'en-US' ];

        return $value;
    }

    /**
     * Unit Test Data Provider for Accept header charset(s).
     *
     * @return array $value Array of charset(s)
     */
    public function acceptCharsetProvider()
    {
        $value   = [];
        $value[] = [ 'utf-8' ];

        return $value;
    }

}

?>
