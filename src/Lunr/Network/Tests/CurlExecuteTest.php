<?php

/**
 * This file contains the CurlExecuteTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Network
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for init and execution in Curl class.
 *
 * @covers Lunr\Network\Curl
 */
class CurlExecuteTest extends CurlTest
{

    /**
     * Test that execute() resets headers after a request.
     *
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteResetsHeaders()
    {
        $property = $this->reflection->getProperty('headers');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, ['h1']);

        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertArrayEmpty($this->get_reflection_property_value('headers'));

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that execute() resets options after a request.
     *
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteDoesNotSetHeaderOptionIfHeadersEmpty()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $method->invokeArgs($this->class, ['http://localhost/']);

        $value = $this->get_reflection_property_value('options');

        $this->assertInternalType('array', $value);

        $this->assertArrayHasKey(CURLOPT_TIMEOUT, $value);
        $this->assertArrayHasKey(CURLOPT_RETURNTRANSFER, $value);
        $this->assertArrayHasKey(CURLOPT_FOLLOWLOCATION, $value);
        $this->assertArrayHasKey(CURLOPT_FAILONERROR, $value);

        $this->assertEquals(30, $value[CURLOPT_TIMEOUT]);
        $this->assertTrue($value[CURLOPT_RETURNTRANSFER]);
        $this->assertTrue($value[CURLOPT_FOLLOWLOCATION]);
        $this->assertTrue($value[CURLOPT_FAILONERROR]);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that execute returns a CurlResponse object on successful request.
     *
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsResponseObjectOnSuccess()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $return = $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that execute returns a CurlResponse object on failed request.
     *
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsResponseObjectOnError()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_FALSE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $return = $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_close');
    }

}

?>
