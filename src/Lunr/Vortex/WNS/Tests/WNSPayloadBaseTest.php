<?php

/**
 * This file contains the WNSPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSPayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSPayload
 */
class WNSPayloadBaseTest extends WNSPayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('elements'));
    }

    /**
     * Test escape_string() works correctly.
     *
     * @param string $string   Unescaped base string
     * @param string $expected Expected escaped string
     *
     * @dataProvider stringProvider
     * @covers       Lunr\Vortex\WNS\WNSPayload::escape_string
     */
    public function testEscapeString($string, $expected)
    {
        $method = $this->get_accessible_reflection_method('escape_string');

        $this->assertEquals($expected, $method->invokeArgs($this->class, [ $string ]));
    }

}

?>
