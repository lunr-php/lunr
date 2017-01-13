<?php

/**
 * This file contains the JsonViewPrintTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for the JsonView class.
 *
 * @covers     Lunr\Corona\JsonView
 */
class JsonViewPrintTest extends JsonViewTest
{

    /**
     * JSON return value;
     * @var Array
     */
    private $json;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->json = [ 'a' => 100, 'b' => [ 'z' => TRUE ], 'c' => [ NULL ], 'd' => new \stdClass(), 'e' => 'みんな' ];
    }

    /**
     * Test that print_page() prints JSON with the response code as error info.
     *
     * @param mixed $error_info Non-integer error info value
     *
     * @dataProvider invalidErrorInfoProvider
     * @requires     PHP 5.5.12
     * @requires     extension runkit
     * @covers       Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJsonWithCode($error_info)
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
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_code.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints JSON with an empty string as message if message is missing.
     *
     * @requires PHP 5.5.12
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJsonWithoutMessage()
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
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_empty_message.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() prints JSON.
     *
     * @requires PHP 5.5.12
     * @requires extension runkit
     * @covers   Lunr\Corona\JsonView::print_page
     */
    public function testPrintPagePrintsJson()
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
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() for a non-cli SAPI does not pretty print the output.
     *
     * @covers Lunr\Corona\JsonView::print_page
     */
    public function testPrintPageForWebDoesNotPrettyPrint()
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
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('web'));

        $this->expectOutputString('{"data":{"a":100,"b":{"z":true},"c":[null],"d":{},"e":"みんな"},"status":{"code":4040,"message":"Message"}}');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() with empty data value.
     *
     * @requires PHP 5.5.12
     * @covers   Lunr\Corona\JsonView::print_page
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

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_empty_data.json');

        $this->mock_function('header', '');

        $this->class->print_page();

        $this->unmock_function('header');
    }

    /**
     * Test that print_page() sets the proper JSON content type.
     *
     * @runInSeparateProcess
     *
     * @requires PHP 5.5.12
     * @requires extension xdebug
     * @covers   Lunr\Corona\JsonView::print_page
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
                       ->will($this->returnValue($this->json));

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('sapi'))
                      ->will($this->returnValue('cli'));

        $this->expectOutputMatchesFile(TEST_STATICS . '/Corona/json_complete.json');

        $this->class->print_page();

        $headers = xdebug_get_headers();

        $this->assertInternalType('array', $headers);
        $this->assertNotEmpty($headers);

        $this->assertEquals('Content-type: application/json', $headers[0]);
    }

}

?>
