<?php

/**
 * This file contains the RequestMagicGetTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestMagicGetTest extends RequestTest
{

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param string $key   Key for a request value
     * @param mixed  $value Value of a request value
     *
     * @dataProvider requestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetMethod($key, $value): void
    {
        $this->assertEquals($value, $this->class->$key);
    }

    /**
     * Check that the magic get function correctly returns mocked values if present.
     *
     * @param string $key Key for a request value
     *
     * @dataProvider requestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetWithMockedValue($key): void
    {
        $this->set_reflection_property_value('mock', [ $key => 'mock' ]);

        $this->assertEquals('mock', $this->class->$key);
    }

    /**
     * Check that the magic get function returns NULL for invalid mock values.
     */
    public function testMagicGetWithInvalidMockValue(): void
    {
        $this->set_reflection_property_value('mock', [ 'invalid' => 'mock' ]);

        $this->assertNull($this->class->invalid);
    }

    /**
     * Test that __get() returns NULL for unhandled keys.
     *
     * @param string $key Key for __get()
     *
     * @dataProvider unhandledMagicGetKeysProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetIsNullForUnhandledKeys($key): void
    {
        $this->assertNull($this->class->$key);
    }

}

?>
