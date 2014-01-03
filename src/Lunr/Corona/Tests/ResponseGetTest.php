<?php

/**
 * This file contains the ResponseGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\Response
 */
class ResponseGetTest extends ResponseTest
{

    /**
     * Test getting existing attributes via __get.
     *
     * @param String $attr  Attribute name
     * @param mixed  $value Expected attribute value
     *
     * @dataProvider validResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingExistingAttributes($attr, $value)
    {
        $this->assertEquals($value, $this->class->$attr);
    }

    /**
     * Test getting existing attributes via __get.
     *
     * @param String $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingInaccessibleAttributes($attr)
    {
        $this->assertNull($this->class->$attr);
    }

    /**
     * Test getting existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithExistingKey()
    {
        $data = ['key' => 'value'];

        $this->set_reflection_property_value('data', $data);

        $this->assertEquals('value', $this->class->get_response_data('key'));
    }

    /**
     * Test getting non-existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithNonExistingKey()
    {
        $this->assertNull($this->class->get_response_data('non-existing'));
    }

    /**
     * Test getting all the response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithoutKey()
    {
        $data = [ 'key1' => 'value1', 'key2' => 'value2' ];

        $this->set_reflection_property_value('data', $data);

        $this->assertEquals($data, $this->class->get_response_data());
    }

    /**
     * Test getting existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetExistingErrorMessage()
    {
        $data = ['controller/method' => 'error message'];

        $this->set_reflection_property_value('errmsg', $data);

        $this->assertEquals('error message', $this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting non-existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetNonExistantErrorMessage()
    {
        $this->assertNull($this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetExistingErrorInfo()
    {
        $data = ['controller/method' => 'error info'];

        $this->set_reflection_property_value('errinfo', $data);

        $this->assertEquals('error info', $this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting non-existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetNonExistantErrorInfo()
    {
        $this->assertNull($this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetExistingReturnCode()
    {
        $data = ['controller/method' => 200];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame(200, $this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting non-existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetNonExistantReturnCode()
    {
        $this->assertNull($this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting return code with highest error code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithoutIdentifier()
    {
        $data = ['controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame(500, $this->class->get_return_code());
    }

    /**
     * Test getting identifier of the highest return code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetMaximumReturnCodeIdentifier()
    {
        $data = ['controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertEquals('ID3', $this->class->get_return_code_identifiers(TRUE));
    }

    /**
     * Test getting all return code identifiers.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetAllReturnCodeIdentifiers()
    {
        $data = ['controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame([ 'controller/method', 'ID', 'ID3' ], $this->class->get_return_code_identifiers());
    }

}

?>
