<?php

/**
 * This file contains the ManagementApiUnpublishEntryTest class.
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
class ManagementApiUnpublishEntryTest extends ManagementApiTest
{

    /**
     * Test that unpublish_entry() if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::unpublish_entry
     */
    public function testUnpublishEntryOnRequestError(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url     = 'https://api.contentful.com/spaces//entries/123456/published';
        $headers = [ 'Authorization' => 'Bearer token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::DELETE)
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

        $this->class->unpublish_entry('123456');
    }

    /**
     * Test that unpublish_entry() on success
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::unpublish_entry
     */
    public function testUnpublishEntryOnSuccessfulRequest(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url     = 'https://api.contentful.com/spaces//entries/123456/published';
        $headers = [ 'Authorization' => 'Bearer token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::DELETE)
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;

        $body = [
            'fields' => [ 'id' => '123456' ],
        ];

        $this->response->body = json_encode($body);

        $result = $this->class->unpublish_entry('123456');

        $this->assertSame($body, $result);
    }

}

?>
