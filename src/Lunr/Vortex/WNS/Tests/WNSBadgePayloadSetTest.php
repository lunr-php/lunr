<?php

/**
 * This file contains the WNSBadgePayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
class WNSBadgePayloadSetTest extends WNSBadgePayloadTest
{

    /**
     * Test set_value() works correctly.
     *
     * @covers Lunr\Vortex\WNS\WNSBadgePayload::set_value
     */
    public function testSetValue()
    {
        $this->class->set_value(1);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('value', $value);
        $this->assertEquals(1, $value['value']);
    }

    /**
     * Test fluid interface of set_value().
     *
     * @covers Lunr\Vortex\WNS\WNSBadgePayload::set_value
     */
    public function testSetValueReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_value('text'));
    }

}

?>
