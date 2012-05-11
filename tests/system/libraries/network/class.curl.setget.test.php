<?php

/**
 * This file contains the CurlSetGetTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Network;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the getters and setters of the Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Network\Curl
 */
class CurlSetGetTest extends CurlTest
{

    /**
     * Test that the value of valid properties can be retrieved correctly.
     *
     * @dataProvider validPropertyProvider
     * @covers       Lunr\Libraries\Network\Curl::__get
     */
    public function testGetReturnsValuesForValidProperties($property, $value)
    {
        $this->assertEquals($value, $this->curl->$property);
    }

    /**
     * Test that the value of invalid properties is retrieved as NULL.
     *
     * @covers Lunr\Libraries\Network\Curl::__get
     */
    public function testGetReturnsNullForInvalidProperties()
    {
        $this->assertNull($this->curl->invalid_property);
    }

    /**
     * Test that an option that does not start with 'CURL' is not set.
     *
     * @dataProvider invalidOptionProvider
     * @covers       Lunr\Libraries\Network\Curl::set_option
     */
    public function testSetOptionDoesNotSetIfNameDoesNotStartWithCurl($option)
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $return = $this->curl->set_option($option, 'value');

        $this->assertEquals($old, $property->getValue($this->curl));
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_option() only works with valid curl constants.
     *
     * @covers Lunr\Libraries\Network\Curl::set_option
     */
    public function testSetOptionDoesNotSetIfCurlOptionDoesNotExist()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $return = $this->curl->set_option('CURLOPT_WHATEVER', 'value');

        $this->assertEquals($old, $property->getValue($this->curl));
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_option() sets valid curl options.
     *
     * @covers Lunr\Libraries\Network\Curl::set_option
     */
    public function testSetOptionSetsValidOption()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $this->assertArrayNotHasKey('CURLOPT_TIMEVALUE', $property->getValue($this->curl));

        $return = $this->curl->set_option('CURLOPT_TIMEVALUE', 1);

        $value = $property->getValue($this->curl);

        $this->assertArrayHasKey(CURLOPT_TIMEVALUE, $value);
        $this->assertEquals(1, $value[CURLOPT_TIMEVALUE]);
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_options() does not set options if input is not array.
     *
     * @covers Lunr\Libraries\Network\Curl::set_options
     */
    public function testSetOptionsDoesNotSetIfInputIsNotArray()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $return = $this->curl->set_options('CURLOPT_TIMEVALUE', 1);

        $this->assertEquals($old, $property->getValue($this->curl));
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_options() does set options correctly.
     *
     * @covers Lunr\Libraries\Network\Curl::set_options
     */
    public function testSetOptionsSetsValidOptions()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $this->assertArrayNotHasKey('CURLOPT_TIMEVALUE', $old);
        $this->assertArrayNotHasKey('CURLOPT_PUT', $old);

        $options = array();
        $options['CURLOPT_TIMEVALUE'] = 1;
        $options['CURLOPT_PUT'] = 1;

        $return = $this->curl->set_options($options);

        $value = $property->getValue($this->curl);

        $this->assertArrayHasKey(CURLOPT_TIMEVALUE, $value);
        $this->assertArrayHasKey(CURLOPT_PUT, $value);
        $this->assertEquals(1, $value[CURLOPT_TIMEVALUE]);
        $this->assertEquals(1, $value[CURLOPT_PUT]);
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_http_header() appends to the header array.
     *
     * @covers Lunr\Libraries\Network\Curl::set_http_header
     */
    public function testSetHttpHeaderAppendsHeaderArray()
    {
        $property = $this->curl_reflection->getProperty('headers');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $this->assertNotContains('header', $old);

        $this->curl->set_http_header('header');

        $this->assertContains('header', $property->getValue($this->curl));
    }

    /**
     * Test the fluid interface of the set_http_header() method.
     *
     * @covers Lunr\Libraries\Network\Curl::set_http_header
     */
    public function testSetHttpHeaderReturnsSelfReference()
    {
        $return = $this->curl->set_http_header('header');
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

    /**
     * Test that set_http_headers() appends to the headers array.
     *
     * @covers Lunr\Libraries\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersAppendsHeaderArrayIfInputIsArray()
    {
        $headers = array('h1', 'h2');

        $property = $this->curl_reflection->getProperty('headers');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $this->assertNotContains('h1', $old);
        $this->assertNotContains('h2', $old);

        $this->curl->set_http_headers($headers);

        $new = $property->getValue($this->curl);

        $this->assertContains('h1', $new);
        $this->assertContains('h2', $new);
    }

    /**
     * Test that set_http_headers() does not append to the headers array if input is not an array.
     *
     * @covers Lunr\Libraries\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersDoesNotAppendHeaderArrayIfInputIsNotArray()
    {
        $property = $this->curl_reflection->getProperty('headers');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $this->curl->set_http_headers('h1');

        $this->assertEquals($old, $property->getValue($this->curl));
    }

    /**
     * Test the fluid interface of the set_http_headers() method.
     *
     * @covers Lunr\Libraries\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersReturnsSelfReference()
    {
        $return = $this->curl->set_http_header(array('header'));
        $this->assertInstanceOf('Lunr\Libraries\Network\Curl', $return);
    }

}

?>
