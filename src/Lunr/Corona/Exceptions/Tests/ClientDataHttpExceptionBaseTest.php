<?php

/**
 * This file contains the ClientDataHttpExceptionBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the ClientDataHttpException class.
 *
 * @covers Lunr\Corona\Exceptions\ClientDataHttpException
 */
class ClientDataHttpExceptionBaseTest extends ClientDataHttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 400);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->app_code);
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

    /**
     * Test that getAppCode() returns the application error code.
     *
     * @covers Lunr\Corona\Exceptions\ClientDataHttpException::getAppCode
     */
    public function testGetAppCodeReturnsAppCode(): void
    {
        $this->assertSame($this->app_code, $this->class->getAppCode());
    }

}

?>
