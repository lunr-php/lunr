<?php

/**
 * This file contains the EmailDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
class EmailDispatcherBaseTest extends EmailDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoint is set to an empty array by default.
     */
    public function testEndpointIsEmptyArray()
    {
        $this->assertPropertyEmpty('endpoint');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEmpty('payload');
    }

    /**
     * Test that the source is set to an empty string by default.
     */
    public function testSourceIsEmptyString()
    {
        $this->assertPropertyEmpty('source');
    }

    /**
     * Test that the passed Mail object is set correctly.
     */
    public function testMailIsSetCorrectly()
    {
        $this->assertSame($this->mail, $this->get_reflection_property_value('mail'));
    }

}

?>
