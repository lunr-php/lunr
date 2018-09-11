<?php

/**
 * This file contains the MPNSPayloadGetTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSPriority;

/**
 * This class contains tests for the getters of the MPNSPayload class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSPayload
 */
class MPNSPayloadGetTest extends MPNSPayloadTest
{

    /**
     * Test get_priority() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSPayload::get_priority
     */
    public function testSetPioritySetsValidPriority()
    {
        $this->assertEquals(MPNSPriority::DEFAULT, $this->class->get_priority());
    }

}

?>
