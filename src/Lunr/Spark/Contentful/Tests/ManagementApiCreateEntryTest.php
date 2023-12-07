<?php

/**
 * This file contains the ManagementApiCreateEntryTest class.
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
class ManagementApiCreateEntryTest extends ManagementApiTest
{

    /**
     * Test that create_entry() if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::create_entry
     */
    public function testCreateEntryOnRequestError(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.management_token')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('Token');

        $url     = 'https://api.contentful.com/entries';
        $headers = [
            'X-Contentful-Content-Type' => 'airport',
            'Authorization'             => 'Bearer Token',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, '{"name":"yo"}', Requests::POST)
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

        $this->class->create_entry('airport', [ 'name' => 'yo' ]);
    }

    /**
     * Test that create_entry() on success
     *
     * @covers Lunr\Spark\Contentful\ManagementApi::create_entry
     */
    public function testCreateEntryOnSuccessfulRequest(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.management_token')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('Token');

        $url     = 'https://api.contentful.com/entries';
        $headers = [
            'X-Contentful-Content-Type' => 'airport',
            'Authorization'             => 'Bearer Token',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, $headers, '{"name":"yo"}', Requests::POST)
                   ->willReturn($this->response);

        $this->response->status_code = 200;

        $body = [
            'fields' => [ 'id' => '123456' ],
        ];

        $this->response->body = json_encode($body);

        $result = $this->class->create_entry('airport', [ 'name' => 'yo' ]);

        $this->assertSame($body, $result);
    }

}

?>
