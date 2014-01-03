<?php

/**
 * This file contains the ResponseSetTest class.
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
class ResponseSetTest extends ResponseTest
{

    /**
     * Test that setting data directly does not work.
     *
     * @param String $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__set
     */
    public function testSetInaccessibleAttributesDoesNotWork($attr)
    {
        $this->class->$attr = 'value';

        $this->assertArrayEmpty($this->get_reflection_property_value($attr));
    }

    /**
     * Test setting a view.
     *
     * @covers Lunr\Corona\Response::__set
     */
    public function testSetView()
    {
        $this->class->view = 'TestView';

        $this->assertEquals('TestView', $this->get_reflection_property_value('view'));
    }

    /**
     * Test adding response data.
     *
     * @covers Lunr\Corona\Response::add_response_data
     */
    public function testAddResponseData()
    {
        $this->class->add_response_data('key', 'value');

        $value = $this->get_reflection_property_value('data');

        $this->assertArrayHasKey('key', $value);
        $this->assertEquals('value', $value['key']);
    }

    /**
     * Test setting an error message.
     *
     * @covers Lunr\Corona\Response::set_error_message
     */
    public function testSetErrorMessage()
    {
        $this->class->set_error_message('ID', 'Message');

        $value = $this->get_reflection_property_value('errmsg');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Message', $value['ID']);
    }

    /**
     * Test setting an error information.
     *
     * @covers Lunr\Corona\Response::set_error_info
     */
    public function testSetErrorInformation()
    {
        $this->class->set_error_info('ID', 'Info');

        $value = $this->get_reflection_property_value('errinfo');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Info', $value['ID']);
    }

    /**
     * Test setting a valid return code.
     *
     * @covers Lunr\Corona\Response::set_return_code
     */
    public function testSetValidReturnCode()
    {
        $this->class->set_return_code('ID', 503);

        $value = $this->get_reflection_property_value('return_code');

        $this->assertArrayHasKey('ID', $value);
        $this->assertSame(503, $value['ID']);
    }

    /**
     * Test setting a valid return code.
     *
     * @param mixed $code Invalid return code value.
     *
     * @dataProvider invalidReturnCodeProvider
     * @covers       Lunr\Corona\Response::set_return_code
     */
    public function testSetInvalidReturnCode($code)
    {
        $this->class->set_return_code('ID', $code);

        $this->assertArrayEmpty($this->get_reflection_property_value('return_code'));
    }

}

?>
