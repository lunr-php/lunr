<?php

/**
 * This file contains the MPNSDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSType;
use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the MPNSDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSDispatcher
 */
class MPNSDispatcherBaseTest extends MPNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoint is set to an empty string by default.
     */
    public function testEndpointIsEmptyString()
    {
        $this->assertPropertyEquals('endpoint', '');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEquals('payload', '');
    }

    /**
     * Test that the priority is set to 0 by default.
     */
    public function testPriorityIsZero()
    {
        $this->assertSame(0, $this->get_reflection_property_value('priority'));
    }

    /**
     * Test that the passed Curl object is set correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertSame($this->curl, $this->get_reflection_property_value('curl'));
    }

    /**
     * Test that the type is set to RAW by default.
     */
    public function testTypeIsSetToRaw()
    {
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

    /**
     * Test that the passed Header object is set correctly.
     */
    public function testHeaderIsSetCorrectly()
    {
        $this->assertSame($this->header, $this->get_reflection_property_value('header'));
    }

}

?>
