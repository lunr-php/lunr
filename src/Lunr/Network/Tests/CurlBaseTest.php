<?php

/**
 * This file contains the CurlBaseTest class.
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
 * This class contains basic test methods for the Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
class CurlBaseTest extends CurlTest
{

    /**
     * Test that headers is an empty array by default.
     */
    public function testHeadersIsEmptyArray()
    {
        $property = $this->curl_reflection->getProperty('headers');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->curl);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that error_number is 0 by default.
     */
    public function testErrorNumberIsZero()
    {
        $property = $this->curl_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->curl));
    }

    /**
     * Test that errmsg is an empty string by default.
     */
    public function testErrorMessageIsEmptyString()
    {
        $property = $this->curl_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->curl));
    }

    /**
     * Test that info is an empty array by default.
     */
    public function testInfoIsEmptyArray()
    {
        $property = $this->curl_reflection->getProperty('info');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->curl);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that http_code is 0 by default.
     */
    public function testHttpCodeIsZero()
    {
        $property = $this->curl_reflection->getProperty('http_code');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->curl));
    }

    /**
     * Test that handle is NULL by default.
     */
    public function testHandleIsNull()
    {
        $property = $this->curl_reflection->getProperty('handle');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->curl));
    }

    /**
     * Test that options are set up correctly.
     */
    public function testOptionsSetupCorrectly()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->curl);

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

}

?>
