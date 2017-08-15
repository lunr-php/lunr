<?php

/**
 * This file contains the CacheHandlerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Cache
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Cache\Tests;

/**
 * This class contains test methods for the CacheHandlerBaseTest class.
 *
 * @covers Lunr\Cache\Cache
 */
class CacheHandlerBaseTest extends CacheHandlerTest
{

    /**
     * Test that the Pool class is set correctly.
     */
    public function testPoolSetCorrectly()
    {
        $this->assertSame($this->cache_pool, $this->get_reflection_property_value('cache_pool'));
    }

}

?>
