<?php

/**
 * This file contains the StreamSocketBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

/**
 * This class contains basic test methods for the StreamSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocket
 */
class StreamSocketBaseTest extends StreamSocketTest
{

    /**
     * Tests that context_options is an empty array by default.
     */
    public function testContextOptionsIsEmptyArray()
    {
        $value = $this->get_reflection_property_value('context_options');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that meta data info is an empty array by default.
     */
    public function testMetaDataIsEmptyArray()
    {
        $value = $this->get_reflection_property_value('meta_data');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that flags is an empty array by default.
     */
    public function testFlagsIsEmptyArray()
    {
        $value = $this->get_reflection_property_value('flags');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that error_number equals 0 by default.
     */
    public function testErrorNumberIsZero()
    {
        $this->assertPropertyEquals('error_number', 0);
    }

    /**
     * Tests that blocking equals TRUE by default.
     */
    public function testBlockingIsOne()
    {
        $this->assertTrue($this->get_reflection_property_value('blocking'));
    }

    /**
     * Tests that error_message is an empty string by default.
     */
    public function testErrorMessageIsEmptyString()
    {
        $this->assertPropertyEquals('error_message', '');
    }

    /**
     * Tests that notification is an empty string by default.
     */
    public function testNotificationIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('notification'));
    }

    /**
     * Tests that handle is NULL by default.
     */
    public function testHandleIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('handle'));
    }

    /**
     * Tests that context is NULL by default.
     */
    public function testContextIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('context'));
    }

    /**
     * Tests that timeout_seconds equals 60 by default.
     */
    public function testTimeoutSecondsInitValue()
    {
        $this->assertPropertyEquals('timeout_seconds', 60);
    }

    /**
     * Tests that timeout_micros equals 0 by default.
     */
    public function testTimeoutMicrosEqualsZero()
    {
        $this->assertPropertyEquals('timeout_microseconds', 0);
    }

}

?>
