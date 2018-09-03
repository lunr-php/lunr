<?php

/**
 * This file contains the HttpExceptionNoAppCodeTest class.
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
class HttpExceptionNoAppCodeTest extends HttpExceptionTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        parent::setUpNoAppCode();
    }

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
        $this->assertPropertySame('app_code', $this->code);
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
        $this->assertSame($this->code, $this->class->getAppCode());
    }

}

?>
