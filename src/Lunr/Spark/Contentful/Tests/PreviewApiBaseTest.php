<?php

/**
 * This file contains the PreviewApiBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains the tests for the PreviewApi.
 *
 * @covers Lunr\Spark\Contentful\PreviewApi
 */
class PreviewApiBaseTest extends PreviewApiTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the CentralAuthenticationStore class is passed correctly.
     */
    public function testCasIsSetCorrectly()
    {
        $this->assertPropertySame('cas', $this->cas);
    }

    /**
     * Test that the Requests_Session class is passed correctly.
     */
    public function testRequestsSessionIsSetCorrectly()
    {
        $this->assertPropertySame('http', $this->http);
    }

}

?>
