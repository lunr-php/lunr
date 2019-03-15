<?php

/**
 * This file contains the GCMResponseBaseTest class.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

/**
 * This class contains base tests for the GCMResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseBaseTest extends GCMResponseTest
{

    /**
     * Test statuses is initialized as an empty array.
     */
    public function testStatusesIsInitializedAsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('statuses'));
    }

}

?>
