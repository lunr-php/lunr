<?php

/**
 * This file contains the HttpExceptionNoAppCodeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the HttpException class.
 *
 * @covers Lunr\Corona\Exceptions\HttpException
 */
class HttpExceptionNoAppCodeTest extends HttpExceptionTestCase
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpNoAppCode();
    }

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
        $this->assertPropertySame('app_code', $this->code);
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
     * @covers Lunr\Corona\Exceptions\HttpException::getAppCode
     */
    public function testGetAppCodeReturnsAppCode(): void
    {
        $this->assertSame($this->code, $this->class->getAppCode());
    }

}

?>
