<?php

/**
 * This file contains the ConflictExceptionBaseTest class.
 *
 * PHP Version 7.0
 *
 * @package Lunr\Corona\Exceptions
 * @author  Damien Tardy-Panis <damien@m2mobi.com>
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\Tests\Helpers\HttpExceptionTest;
use Exception;

/**
 * This class contains tests for the ConflictException class.
 *
 * @covers Lunr\Corona\Exceptions\ConflictException
 */
class ConflictExceptionBaseTest extends HttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     */
    public function testErrorCodeSetCorrectly()
    {
        $this->assertPropertySame('code', 409);
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

}

?>
