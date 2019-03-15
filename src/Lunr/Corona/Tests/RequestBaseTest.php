<?php

/**
 * This file contains the RequestBaseTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestBaseTest extends RequestTest
{

    /**
     * Check that post values are set correctly.
     */
    public function testPost(): void
    {
        $this->assertEquals([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ], $this->get_reflection_property_value('post'));
    }

    /**
     * Check that server values are set correctly.
     */
    public function testServer(): void
    {
        $server = [
            'server_key'      => 'server_value',
            'HTTP_SERVER_KEY' => 'HTTP_SERVER_VALUE',
        ];

        $this->assertEquals($server, $this->get_reflection_property_value('server'));
    }

    /**
     * Check that get values are set correctly.
     */
    public function testGet(): void
    {
        $this->assertEquals([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ], $this->get_reflection_property_value('get'));
    }

    /**
     * Check that files values are set correctly.
     */
    public function testFiles(): void
    {
        $this->assertEquals($this->files, $this->get_reflection_property_value('files'));
    }

    /**
     * Check that cookie values are set correctly.
     */
    public function testCookie(): void
    {
        $this->assertEquals([ 'cookie_key' => 'cookie_value' ], $this->get_reflection_property_value('cookie'));
    }

    /**
     * Check that cli argument values are set correctly.
     */
    public function testCliArgs(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('cli_args'));
    }

    /**
     * Check that raw data is set correctly.
     */
    public function testRawData(): void
    {
        $this->assertNull($this->get_reflection_property_value('raw_data'));
    }

    /**
     * Check that request is filled with sane default values.
     *
     * @param string $key   Key for a request value
     * @param mixed  $value Value of a request value
     *
     * @dataProvider requestValueProvider
     */
    public function testRequestDefaultValues($key, $value): void
    {
        $request = $this->get_reflection_property_value('request');

        $this->assertArrayHasKey($key, $request);
        $this->assertEquals($value, $request[$key]);
    }

}

?>
