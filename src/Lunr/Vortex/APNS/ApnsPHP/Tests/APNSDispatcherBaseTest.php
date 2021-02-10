<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
class APNSDispatcherBaseTest extends APNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the APNS message property is set to NULL.
     */
    public function testAPNSMessageIsNull(): void
    {
        $this->assertPropertyUnset('apns_message');
    }

    /**
     * Test that the APNS message function returns correctly.
     *
     * @covers \Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::get_new_apns_message
     */
    public function testNewAPNSMessage(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_apns_message');
        $result = $method->invokeArgs($this->class, []);

        $this->assertInstanceOf(\ApnsPHP_Message::class, $result);
    }

}

?>
