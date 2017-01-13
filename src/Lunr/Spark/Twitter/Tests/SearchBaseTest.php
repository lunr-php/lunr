<?php

/**
 * This file contains the SearchBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Search class.
 *
 * @covers Lunr\Spark\Twitter\Search
 */
class SearchBaseTest extends SearchTest
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
