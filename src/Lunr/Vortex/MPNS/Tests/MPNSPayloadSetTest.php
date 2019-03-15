<?php

/**
 * This file contains the MPNSPayloadSetTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSPriority;

/**
 * This class contains tests for the setters of the MPNSPayload class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSPayload
 */
class MPNSPayloadSetTest extends MPNSPayloadTest
{

    /**
     * Test set_priority() works correctly.
     *
     * @dataProvider validPriorityProvider
     * @covers Lunr\Vortex\MPNS\MPNSPayload::set_priority
     */
    public function testSetPioritySetsValidPriority($priority): void
    {
        $this->class->set_priority($priority);

        $this->assertEquals($priority, $this->get_reflection_property_value('priority'));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSPayload::set_priority
     */
    public function testSetPriorityDoesNotSetInvalidPriority(): void
    {
        $this->class->set_priority(9000);

        $priority = $this->get_reflection_property_value('priority');

        $this->assertEquals(MPNSPriority::DEFAULT, $priority);
    }

}

?>
