<?php

/**
 * This file contains the ManagementApiGetEntryTest class.
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Requests_Exception_HTTP_400;
use Requests;

/**
 * This class contains the tests for the ManagementApi.
 *
 * @covers Lunr\Spark\Contentful\ManagementApi
 */
class ManagementApiGetEntryTest extends ManagementApiTest
{

    /**
     * Test that get_entry() if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::get_entry
     */
    public function testGetEntryOnRequestError(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('management_token'))
                  ->will($this->returnValue('token'));

        $url     = 'https://api.contentful.com/entries/123456';
        $headers = [ 'Authorization' => 'Bearer token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::GET)
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Bad request', $this->response)));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Contentful API Request ({request}) failed: {message}',
                         [ 'message' => '400 Bad request', 'request' => $url ]
                     );

        $this->expectException('Requests_Exception_HTTP_400');
        $this->expectExceptionMessage('Bad request');

        $this->class->get_entry('123456');
    }

    /**
     * Test that get_entry() on success
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::get_entry
     */
    public function testGetEntryOnSuccessfulRequest(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('management_token'))
                  ->will($this->returnValue('token'));

        $url     = 'https://api.contentful.com/entries/123456';
        $headers = [ 'Authorization' => 'Bearer token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::GET)
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;

        $body = [
            'fields' => [ 'id' => '123456' ],
        ];

        $this->response->body = json_encode($body);

        $result = $this->class->get_entry('123456');

        $this->assertSame($body, $result);
    }

}

?>
