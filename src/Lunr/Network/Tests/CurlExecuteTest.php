<?php

/**
 * This file contains the CurlExecuteTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for init and execution in Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
class CurlExecuteTest extends CurlTest
{

    /**
     * Test that execute() resets headers after a request.
     *
     * @runInSeparateProcess
     *
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteResetsHeaders()
    {
        $property = $this->reflection->getProperty('headers');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, ['h1']);

        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertArrayEmpty($this->get_reflection_property_value('headers'));
    }

    /**
     * Test that execute() resets options after a request.
     *
     * @runInSeparateProcess
     *
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteDoesNotSetHeaderOptionIfHeadersEmpty()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

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
    }

    /**
     * Test that execute returns a CurlResponse object on successful request.
     *
     * @runInSeparateProcess
     *
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsResponseObjectOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $return = $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

    /**
     * Test that execute returns a CurlResponse object on failed request.
     *
     * @runInSeparateProcess
     *
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsResponseObjectOnError()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->get_accessible_reflection_method('execute');
        $return = $method->invokeArgs($this->class, ['http://localhost/']);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

}

?>
