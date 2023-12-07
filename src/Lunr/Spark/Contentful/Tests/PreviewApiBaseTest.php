<?php

/**
 * This file contains the PreviewApiBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the PreviewApi.
 *
 * @covers Lunr\Spark\Contentful\PreviewApi
 */
class PreviewApiBaseTest extends PreviewApiTest
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

}

?>
