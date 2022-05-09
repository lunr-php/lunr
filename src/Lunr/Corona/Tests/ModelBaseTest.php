<?php

/**
 * This file contains the ModelBaseTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
class ModelBaseTest extends ModelTest
{

    /**
     * Test that the Pool class is set correctly.
     */
    public function testPoolSetCorrectly(): void
    {
        $this->assertPropertySame('cache', $this->cache);
    }

}

?>
