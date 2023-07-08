<?php

/**
 * This file contains the MsgpackViewPrintTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the MsgpackView class.
 *
 * @covers     Lunr\Corona\MsgpackView
 */
class MsgpackViewPrintTest extends MsgpackViewTest
{

    /**
     * MSGPACK return value;
     * @var array
     */
    private $msgpack;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->msgpack = [ 'a' => 100, 'b' => [ 'z' => TRUE ], 'c' => [ NULL ], 'd' => new \stdClass(), 'e' => 'カワイイ' ];
    }

    /**
     * Test that print_page() prints MSGPACK with the response code as error info.
     *
     * @param mixed $error_info Non-integer error info value
     *
     * @dataProvider invalidErrorInfoProvider
     * @requires     extension msgpack
     * @covers       Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPagePrintsmsgpackWithCode($error_info): void
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with(TRUE)
                       ->willReturn('id');

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with('id')
                       ->willReturn(NULL);

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with('id')
                       ->willReturn('Message');

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with('id')
                       ->willReturn(404);

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->willReturn($this->msgpack);

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_code.msgpack');

        $this->mock_function('header', function (){});

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints MSGPACK with an empty string as message if message is missing.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPagePrintsmsgpackWithoutMessage(): void
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with(TRUE)
                       ->willReturn('id');

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with('id')
                       ->willReturn(NULL);

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with('id')
                       ->willReturn(NULL);

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with('id')
                       ->willReturn(404);

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->willReturn($this->msgpack);

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_empty_message.msgpack');

        $this->mock_function('header', function (){});

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints MSGPACK.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPagePrintsmsgpack(): void
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with(TRUE)
                       ->willReturn('id');

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with('id')
                       ->willReturn(4040);

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with('id')
                       ->willReturn('Message');

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with('id')
                       ->willReturn(404);

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->willReturn($this->msgpack);

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_complete.msgpack');

        $this->mock_function('header', function (){});

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() with empty data value.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPageWithEmptyData(): void
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with(TRUE)
                       ->willReturn('id');

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with('id')
                       ->willReturn(4040);

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with('id')
                       ->willReturn('Message');

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with('id')
                       ->willReturn(404);

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->willReturn([]);

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_empty_data.msgpack');

        $this->mock_function('header', function (){});

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() sets the proper MSGPACK content type.
     *
     * @runInSeparateProcess
     *
     * @requires extension msgpack
     * @requires extension xdebug
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPageSetsContentType(): void
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with(TRUE)
                       ->willReturn('id');

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with('id')
                       ->willReturn(4040);

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with('id')
                       ->willReturn('Message');

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with('id')
                       ->willReturn(404);

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->willReturn($this->msgpack);

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_complete.msgpack');

        $this->class->print_page();

        $headers = xdebug_get_headers();

        $this->assertIsArray($headers);
        $this->assertNotEmpty($headers);

        $value = strpos($headers[0], 'X-Xdebug-Profile-Filename') !== FALSE ? $headers[2] : $headers[1];

        $this->assertEquals('Content-type: application/msgpack', $value);
    }

}

?>
