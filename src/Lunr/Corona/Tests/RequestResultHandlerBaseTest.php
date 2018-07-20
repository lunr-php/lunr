<?php

/**
 * This file contains the RequestResultHandlerBaseTest class.
 *
 * PHP Version 7.0
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerBaseTest extends RequestResultHandlerTest
{

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the Response class was passed correctly.
     */
    public function testResponsePassedCorrectly()
    {
        $this->assertPropertySame('response', $this->response);
    }

    /**
     * Test that __call() returns NULL.
     *
     * @covers Lunr\Corona\RequestResultHandler::__call
     */
    public function testCallIsVoid()
    {
        $this->assertNull($this->class->log_http_100());
    }

}

?>
