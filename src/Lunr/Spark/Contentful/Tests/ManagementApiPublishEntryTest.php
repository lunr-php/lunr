<?php

/**
 * This file contains the ManagementApiPublishEntryTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

use WpOrg\Requests\Exception\Http\Status400 as RequestsExceptionHTTP400;
use WpOrg\Requests\Requests;

/**
 * This class contains the tests for the ManagementApi.
 *
 * @covers Lunr\Spark\Contentful\ManagementApi
 */
class ManagementApiPublishEntryTest extends ManagementApiTest
{

    /**
     * Test that publish_entry() if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::publish_entry
     */
    public function testPublishEntryOnRequestError(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.management_token')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('token');

        $url     = 'https://api.contentful.com/entries/123456/published';
        $headers = [
            'X-Contentful-Version' => 7,
            'Authorization'        => 'Bearer token',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::PUT)
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new RequestsExceptionHTTP400('Bad request', $this->response));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Contentful API Request ({request}) failed: {message}',
                         [ 'message' => '400 Bad request', 'request' => $url ]
                     );

        $this->expectException('WpOrg\Requests\Exception\Http\Status400');
        $this->expectExceptionMessage('Bad request');

        $this->class->publish_entry('123456', 7);
    }

    /**
     * Test that publish_entry() on success
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::publish_entry
     */
    public function testPublishEntryOnSuccessfulRequest(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.management_token')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('token');

        $url     = 'https://api.contentful.com/entries/123456/published';
        $headers = [
            'X-Contentful-Version' => 7,
            'Authorization'        => 'Bearer token',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, [], Requests::PUT)
                   ->willReturn($this->response);

        $this->response->status_code = 200;

        $body = [
            'fields' => [ 'id' => '123456' ],
        ];

        $this->response->body = json_encode($body);

        $result = $this->class->publish_entry('123456', 7);

        $this->assertSame($body, $result);
    }

}

?>
