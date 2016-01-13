<?php

/**
 * This file contains the WNSTilePayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
class WNSTilePayloadSetTest extends WNSTilePayloadTest
{

    /**
     * Test set_text() works correctly.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetText()
    {
        $this->class->set_text('&text');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals('&amp;text', $value['text']);
    }

    /**
     * Test fluid interface of set_text().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_text('text'));
    }

}

?>
