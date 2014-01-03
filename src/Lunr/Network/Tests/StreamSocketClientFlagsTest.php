<?php

/**
 * This file contains the StreamSocketClientFlagsTest class.
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
 * This class contains test methods for flags of the StreamClientSocket class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Network\StreamSocketClient
 */
class StreamSocketClientFlagsTest extends StreamSocketClientTest
{

    /**
     * Tests that a valid flag is properly added if not present.
     *
     * @covers Lunr\Network\StreamSocketClient::add_flag
     */
    public function testAddValidFlagIfNotPresent()
    {
        $previous = $this->get_reflection_property_value('flags');

        $this->class->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $this->get_reflection_property_value('flags');

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_PERSISTENT, $new);

        $previous = $this->get_reflection_property_value('flags');

        $this->class->add_flag('STREAM_CLIENT_ASYNC_CONNECT');

        $new = $this->get_reflection_property_value('flags');

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_ASYNC_CONNECT, $new);
    }

    /**
     * Tests that a valid flag is not added if present.
     *
     * @covers Lunr\Network\StreamSocketClient::add_flag
     */
    public function testDoNotAddValidFlagIfPresent()
    {
        $this->class->add_flag('STREAM_CLIENT_PERSISTENT');

        $previous = $this->get_reflection_property_value('flags');

        $this->class->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $this->get_reflection_property_value('flags');

        $this->assertEquals($previous, $new);
    }

    /**
     * Tests that an invalid flag is not added to flags.
     *
     * @dataProvider invalidFlagProvider
     * @covers       Lunr\Network\StreamSocketClient::add_flag
     */
    public function testDoNotAddInvalidFlag()
    {
        $previous = $this->get_reflection_property_value('flags');

        $this->class->add_flag('STREAM_CLIENT_PERSISTENT');

        $new = $this->get_reflection_property_value('flags');

        $this->assertTrue(count($new) === count($previous) + 1);
        $this->assertContains(STREAM_CLIENT_PERSISTENT, $new);
    }

    /**
     * Tests that create_flags() merges the given int to the total.
     *
     * @covers Lunr\Network\StreamSocketClient::create_flags
     */
    public function testCreateFlags()
    {
        $method = $this->get_accessible_reflection_method('create_flags');

        $this->assertEquals(3, $method->invokeArgs($this->class, [2, 1]));
    }

}

?>
