<?php

/**
 * This file contains the CurlSetGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

/**
 * This class contains test methods for the getters and setters of the Curl class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
class CurlSetGetTest extends CurlTest
{

    /**
     * Test that an option that does not start with 'CURL' is not set.
     *
     * @param String $option Option name
     *
     * @dataProvider invalidOptionProvider
     * @covers       Lunr\Network\Curl::set_option
     */
    public function testSetOptionDoesNotSetIfNameDoesNotStartWithCurl($option)
    {
        $property = $this->get_accessible_reflection_property('options');

        $old = $property->getValue($this->class);

        $return = $this->class->set_option($option, 'value');

        $this->assertEquals($old, $property->getValue($this->class));
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_option() only works with valid curl constants.
     *
     * @covers Lunr\Network\Curl::set_option
     */
    public function testSetOptionDoesNotSetIfCurlOptionDoesNotExist()
    {
        $property = $this->get_accessible_reflection_property('options');

        $old = $property->getValue($this->class);

        $return = $this->class->set_option('CURLOPT_WHATEVER', 'value');

        $this->assertEquals($old, $property->getValue($this->class));
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_option() sets valid curl options.
     *
     * @covers Lunr\Network\Curl::set_option
     */
    public function testSetOptionSetsValidOption()
    {
        $property = $this->get_accessible_reflection_property('options');

        $this->assertArrayNotHasKey('CURLOPT_TIMEVALUE', $property->getValue($this->class));

        $return = $this->class->set_option('CURLOPT_TIMEVALUE', 1);

        $value = $property->getValue($this->class);

        $this->assertArrayHasKey(CURLOPT_TIMEVALUE, $value);
        $this->assertEquals(1, $value[CURLOPT_TIMEVALUE]);
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_options() does not set options if input is not array.
     *
     * @covers Lunr\Network\Curl::set_options
     */
    public function testSetOptionsDoesNotSetIfInputIsNotArray()
    {
        $property = $this->get_accessible_reflection_property('options');

        $old = $property->getValue($this->class);

        $return = $this->class->set_options('CURLOPT_TIMEVALUE', 1);

        $this->assertEquals($old, $property->getValue($this->class));
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_options() does set options correctly.
     *
     * @covers Lunr\Network\Curl::set_options
     */
    public function testSetOptionsSetsValidOptions()
    {
        $property = $this->get_accessible_reflection_property('options');

        $old = $property->getValue($this->class);

        $this->assertArrayNotHasKey('CURLOPT_TIMEVALUE', $old);
        $this->assertArrayNotHasKey('CURLOPT_PUT', $old);

        $options                      = array();
        $options['CURLOPT_TIMEVALUE'] = 1;
        $options['CURLOPT_PUT']       = 1;

        $return = $this->class->set_options($options);

        $value = $property->getValue($this->class);

        $this->assertArrayHasKey(CURLOPT_TIMEVALUE, $value);
        $this->assertArrayHasKey(CURLOPT_PUT, $value);
        $this->assertEquals(1, $value[CURLOPT_TIMEVALUE]);
        $this->assertEquals(1, $value[CURLOPT_PUT]);
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_http_header() appends to the header array.
     *
     * @covers Lunr\Network\Curl::set_http_header
     */
    public function testSetHttpHeaderAppendsHeaderArray()
    {
        $property = $this->get_accessible_reflection_property('headers');

        $old = $property->getValue($this->class);

        $this->assertNotContains('header', $old);

        $this->class->set_http_header('header');

        $this->assertContains('header', $property->getValue($this->class));
    }

    /**
     * Test the fluid interface of the set_http_header() method.
     *
     * @covers Lunr\Network\Curl::set_http_header
     */
    public function testSetHttpHeaderReturnsSelfReference()
    {
        $return = $this->class->set_http_header('header');
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

    /**
     * Test that set_http_headers() appends to the headers array.
     *
     * @covers Lunr\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersAppendsHeaderArrayIfInputIsArray()
    {
        $headers = array('h1', 'h2');

        $property = $this->get_accessible_reflection_property('headers');

        $old = $property->getValue($this->class);

        $this->assertNotContains('h1', $old);
        $this->assertNotContains('h2', $old);

        $this->class->set_http_headers($headers);

        $new = $property->getValue($this->class);

        $this->assertContains('h1', $new);
        $this->assertContains('h2', $new);
    }

    /**
     * Test that set_http_headers() does not append to the headers array if input is not an array.
     *
     * @covers Lunr\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersDoesNotAppendHeaderArrayIfInputIsNotArray()
    {
        $property = $this->get_accessible_reflection_property('headers');

        $old = $property->getValue($this->class);

        $this->class->set_http_headers('h1');

        $this->assertEquals($old, $property->getValue($this->class));
    }

    /**
     * Test the fluid interface of the set_http_headers() method.
     *
     * @covers Lunr\Network\Curl::set_http_headers
     */
    public function testSetHttpHeadersReturnsSelfReference()
    {
        $return = $this->class->set_http_header(array('header'));
        $this->assertInstanceOf('Lunr\Network\Curl', $return);
    }

}

?>
