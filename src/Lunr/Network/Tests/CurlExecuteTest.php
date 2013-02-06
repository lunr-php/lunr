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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
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
     * Test that init() sets header option for curl if headers are not emoty.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitSetsHeaderOptionIfHeadersNotEmpty()
    {
        $property = $this->curl_reflection->getProperty('headers');
        $property->setAccessible(TRUE);
        $property->setValue($this->curl, array('h1'));

        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $method->invokeArgs($this->curl, array('http://localhost/'));

        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $options = $property->getValue($this->curl);
        $this->assertContains(CURLOPT_HTTPHEADER, $options);
        $this->assertEquals(array('h1'), $options[CURLOPT_HTTPHEADER]);
    }

    /**
     * Test that init() does not set header option for curl if headers are empty.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitDoesNotSetHeaderOptionIfHeadersEmpty()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $method->invokeArgs($this->curl, array('http://localhost/'));

        $this->assertEquals($old, $property->getValue($this->curl));
    }

    /**
     * Test that init() sets the handle.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitSetsHandle()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $method->invokeArgs($this->curl, array('http://localhost/'));

        $property = $this->curl_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->curl));
    }

    /**
     * Test that init returns TRUE on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitReturnsTrueOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $return = $method->invokeArgs($this->curl, array('http://localhost/'));

        $this->assertTrue($return);
    }

    /**
     * Test that init returns FALSE on error.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitReturnsFalseOnError()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $return = $method->invokeArgs($this->curl, array('http://localhost/'));

        $this->assertFalse($return);
    }

    /**
     * Test that init sets error_message and error_number on error.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::init
     */
    public function testInitSetsErrorInfoOnError()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);

        $method = $this->curl_reflection->getMethod('init');
        $method->setAccessible(TRUE);
        $method->invokeArgs($this->curl, array('http://localhost/'));

        $errmsg = $this->curl_reflection->getProperty('error_message');
        $errmsg->setAccessible(TRUE);

        $this->assertEquals('Could not set curl options!', $errmsg->getValue($this->curl));

        $errno = $this->curl_reflection->getProperty('error_number');
        $errno->setAccessible(TRUE);

        $this->assertEquals(-1, $errno->getValue($this->curl));
    }

    /**
     * Test that execute sets errmsg, errno and http_code on error.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::execute
     */
    public function testExecuteSetsErrorInfoOnError()
    {
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('execute');
        $method->setAccessible(TRUE);
        $method->invoke($this->curl);

        $errno = $this->curl_reflection->getProperty('error_number');
        $errno->setAccessible(TRUE);

        $this->assertEquals(10, $errno->getValue($this->curl));

        $errmsg = $this->curl_reflection->getProperty('error_message');
        $errmsg->setAccessible(TRUE);

        $this->assertEquals('error', $errmsg->getValue($this->curl));

        $code = $this->curl_reflection->getProperty('http_code');
        $code->setAccessible(TRUE);

        $this->assertEquals(404, $code->getValue($this->curl));
    }

    /**
     * Test that execute sets handle NULL.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::execute
     */
    public function testExecuteSetsHandleNull()
    {
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('execute');
        $method->setAccessible(TRUE);
        $method->invoke($this->curl);

        $property = $this->curl_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->curl));
    }

    /**
     * Test that execute sets info on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::execute
     */
    public function testExecuteSetsInfoOnSuccess()
    {
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_INFO);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('execute');
        $method->setAccessible(TRUE);
        $method->invoke($this->curl);

        $property = $this->curl_reflection->getProperty('info');
        $property->setAccessible(TRUE);

        $this->assertEquals('info', $property->getValue($this->curl));
    }

    /**
     * Test that execute return FALSE on error.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsFalseOnError()
    {
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('execute');
        $method->setAccessible(TRUE);
        $return = $method->invoke($this->curl);

        $this->assertFalse($return);
    }

    /**
     * Test that execute returns value on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Network\Curl::execute
     */
    public function testExecuteReturnsValueOnSuccess()
    {
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_INFO);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $method = $this->curl_reflection->getMethod('execute');
        $method->setAccessible(TRUE);
        $return = $method->invoke($this->curl);

        $this->assertEquals('value', $return);
    }

}

?>
