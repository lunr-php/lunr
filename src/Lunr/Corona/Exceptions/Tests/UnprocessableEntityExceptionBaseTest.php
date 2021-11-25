<?php

/**
 * This file contains the UnprocessableEntityExceptionBaseTest class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    David Mendes <d.mendes@m2mobi.com>
 * @copyright 2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions\Tests;

use Lunr\Corona\Exceptions\Tests\Helpers\HttpExceptionTest;

/**
 * This class contains tests for the UnprocessableEntityException class.
 *
 * @covers Lunr\Corona\Exceptions\UnprocessableEntityException
 */
class UnprocessableEntityExceptionBaseTest extends HttpExceptionTest
{

    /**
     * Test that the error code was set correctly.
     *
     * @covers Lunr\Corona\Exceptions\UnprocessableEntityException::__construct()
     */
    public function testErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('code', 422);
    }

    /**
     * Test that the error code was set correctly.
     *
     * @covers Lunr\Corona\Exceptions\UnprocessableEntityException::__construct()
     */
    public function testApplicationErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('app_code', $this->code);
    }

    /**
     * Test that the error message was passed correctly.
     *
     * @covers Lunr\Corona\Exceptions\UnprocessableEntityException::__construct()
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage($this->message);

        throw $this->class;
    }

}

?>
