<?php

/**
 * This file contains the RequestResultHandlerBaseTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerBaseTest extends RequestResultHandlerTest
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
