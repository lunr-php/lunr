<?php

/**
 * This file contains the MsgpackViewPrintTest class.
 *
 * PHP Version 5.4
 *
 * @package   Lunr\Corona
 * @author    Patrick Valk <p.valk@m2mobi.com>
 * @copyright 2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
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
     * @var Array
     */
    private $msgpack;

    /**
     * Testcase Constructor.
     */
    public function setUp()
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
    public function testPrintPagePrintsmsgpackWithCode($error_info)
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->msgpack));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_code.msgpack');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints MSGPACK with an empty string as message if message is missing.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPagePrintsmsgpackWithoutMessage()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(NULL));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->msgpack));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_empty_message.msgpack');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints MSGPACK.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPagePrintsmsgpack()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->msgpack));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_complete.msgpack');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() with empty data value.
     *
     * @requires extension msgpack
     * @covers   Lunr\Corona\MsgpackView::print_page
     */
    public function testPrintPageWithEmptyData()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue([]));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_empty_data.msgpack');

        $this->mock_function('header', '');

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
    public function testPrintPageSetsContentType()
    {
        $this->response->expects($this->once())
                       ->method('get_return_code_identifiers')
                       ->with($this->equalTo(TRUE))
                       ->will($this->returnValue('id'));

        $this->response->expects($this->once())
                       ->method('get_error_info')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(4040));

        $this->response->expects($this->once())
                       ->method('get_error_message')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue('Message'));

        $this->response->expects($this->once())
                       ->method('get_return_code')
                       ->with($this->equalTo('id'))
                       ->will($this->returnValue(404));

        $this->response->expects($this->once())
                       ->method('get_response_data')
                       ->will($this->returnValue($this->msgpack));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/msgpack_complete.msgpack');

        $this->class->print_page();

        $headers = xdebug_get_headers();

        $this->assertInternalType('array', $headers);
        $this->assertNotEmpty($headers);

        $this->assertEquals('Content-type: application/msgpack', $headers[0]);
    }

}

?>
