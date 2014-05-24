<?php

/**
 * This file contains the RequestParserParseRequestTest class.
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

use Lunr\Halo\RequestParserStaticRequestTestTrait;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Corona\RequestParser
 * @backupGlobals enabled
 */
class RequestParserParseRequestTest extends RequestParserTest
{

    use RequestParserStaticRequestTestTrait;

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

}

?>
