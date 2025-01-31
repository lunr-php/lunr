<?php

/**
 * This file contains the RequestResultHandlerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerBaseTest extends RequestResultHandlerTestCase
{

    use PsrLoggerTestTrait;

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class was passed correctly.
     */
    public function testResponsePassedCorrectly(): void
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that __call() returns NULL.
     *
     * @covers Lunr\Corona\RequestResultHandler::__call
     */
    public function testCallIsVoid(): void
    {
        $this->assertNull($this->class->log_http_100());
    }

}

?>
