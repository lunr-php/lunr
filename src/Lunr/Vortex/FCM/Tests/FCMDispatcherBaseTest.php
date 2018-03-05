<?php

/**
 * This file contains the FCMDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMType;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherBaseTest extends FCMDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoints is set to an empty array by default.
     */
    public function testEndpointsIsEmptyArray()
    {
        $this->assertPropertyEquals('endpoints', []);
    }

}

?>
