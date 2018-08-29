<?php

/**
 * This file contains the MPNSDispatcherSetTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSPriority;
use Lunr\Vortex\MPNS\MPNSType;

/**
 * This class contains tests for the setters of the MPNSDispatcher class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSDispatcher
 */
class MPNSDispatcherSetTest extends MPNSDispatcherTest
{

    /**
     * Test the fluid interface of set_priority().
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::set_priority
     */
    public function testSetPriorityReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_priority(MPNSPriority::TILE_IMMEDIATELY));
    }

    /**
     * Test that set_priority() sets the priority if it is valid.
     *
     * @param integer $priority Valid MPNS Priority
     *
     * @dataProvider validPriorityProvider
     * @covers       Lunr\Vortex\MPNS\MPNSDispatcher::set_priority
     */
    public function testSetPioritySetsValidPriority($priority)
    {
        $this->class->set_priority($priority);

        $this->assertSame($priority, $this->get_reflection_property_value('priority'));
    }

    /**
     * Test that set_priority() ignores the priority if it is invalid.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::set_priority
     */
    public function testSetPriorityDoesNotSetInvalidPriority()
    {
        $this->class->set_priority(100);

        $this->assertEquals(0, $this->get_reflection_property_value('priority'));
    }

}

?>
