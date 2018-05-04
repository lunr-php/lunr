<?php

/**
 * This file contains the HttpExceptionBaseTest class.
 *
 * PHP Version 7.0
 *
 * @package Lunr\Corona\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Corona\Exceptions\Tests;

/**
 * This class contains tests for the HttpException class.
 *
 * @covers Lunr\Corona\Exceptions\HttpException
 */
class HttpExceptionBaseTest extends HttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly()
    {
        $this->assertPropertySame('code', 400);
    }

    /**
     * Test that the error code was set correctly.
     */
    public function testApplicationErrorCodeSetCorrectly()
    {
        $this->assertPropertySame('app_code', $this->app_code);
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly()
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

    /**
     * Test that getAppCode() returns the application error code.
     *
     * @covers Lunr\Corona\Exceptions\HttpException::getAppCode
     */
    public function testGetAppCodeReturnsAppCode()
    {
        $this->assertSame($this->app_code, $this->class->getAppCode());
    }

}

?>
