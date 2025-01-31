<?php

/**
 * This file contains the ResponseSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @covers     Lunr\Corona\Response
 */
class ResponseSetTest extends ResponseTestCase
{

    /**
     * Test that setting data directly does not work.
     *
     * @param string $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__set
     */
    public function testSetInaccessibleAttributesDoesNotWork($attr): void
    {
        $this->class->$attr = 'value';

        $this->assertArrayEmpty($this->getReflectionPropertyValue($attr));
    }

    /**
     * Test setting a view.
     *
     * @covers Lunr\Corona\Response::__set
     */
    public function testSetView(): void
    {
        $this->class->view = 'TestView';

        $this->assertEquals('TestView', $this->getReflectionPropertyValue('view'));
    }

    /**
     * Test adding response data.
     *
     * @covers Lunr\Corona\Response::add_response_data
     */
    public function testAddResponseData(): void
    {
        $this->class->add_response_data('key', 'value');

        $value = $this->getReflectionPropertyValue('data');

        $this->assertArrayHasKey('key', $value);
        $this->assertEquals('value', $value['key']);
    }

    /**
     * Test setting an error message.
     *
     * @covers Lunr\Corona\Response::set_error_message
     */
    public function testSetErrorMessage(): void
    {
        $this->class->set_error_message('ID', 'Message');

        $value = $this->getReflectionPropertyValue('errmsg');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Message', $value['ID']);
    }

    /**
     * Test setting an error information.
     *
     * @covers Lunr\Corona\Response::set_error_info
     */
    public function testSetErrorInformation(): void
    {
        $this->class->set_error_info('ID', 'Info');

        $value = $this->getReflectionPropertyValue('errinfo');

        $this->assertArrayHasKey('ID', $value);
        $this->assertEquals('Info', $value['ID']);
    }

    /**
     * Test setting a valid return code.
     *
     * @covers Lunr\Corona\Response::set_return_code
     */
    public function testSetValidReturnCode(): void
    {
        $this->class->set_return_code('ID', 503);

        $value = $this->getReflectionPropertyValue('returnCode');

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
    public function testSetInvalidReturnCode($code): void
    {
        $this->class->set_return_code('ID', $code);

        $this->assertArrayEmpty($this->getReflectionPropertyValue('returnCode'));
    }

}

?>
