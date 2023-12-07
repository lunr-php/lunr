<?php

/**
 * This file contains the ApiBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Contentful\Api
 */
class ApiBaseTest extends ApiTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the credentials cache is passed correctly.
     */
    public function testCacheIsSetCorrectly(): void
    {
        $this->assertPropertySame('cache', $this->cache);
    }

    /**
     * Test that the Requests_Session class is passed correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that __get() gets existing credential values from the credentials cache.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Contentful\Api::__get
     */
    public function testGetExistingCredentials($key): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.' . $key)
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('value');

        $this->assertEquals('value', $this->class->{$key});
    }

    /**
     * Test that __get() returns NULL for non-existing credential keys.
     *
     * @covers Lunr\Spark\Contentful\Api::__get
     */
    public function testGetNonExistingCredentials(): void
    {
        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->assertNull($this->class->invalid);
    }

    /**
     * Test that __set() sets general credential values in the credentials cache.
     *
     * @param string $key Credential key
     *
     * @dataProvider generalKeyProvider
     * @covers       Lunr\Spark\Contentful\Api::__set
     */
    public function testSetGeneralCredentials($key): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('contentful.' . $key)
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('value');

        $this->class->{$key} = 'value';
    }

    /**
     * Test that setting an invalid key does not touch the credentials cache.
     *
     * @covers Lunr\Spark\Contentful\Api::__set
     */
    public function testSetInvalidKeyDoesNotAlterCredentialsCache(): void
    {
        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->cache->expects($this->never())
                    ->method('save');

        $this->class->invalid = 'value';
    }

}

?>
