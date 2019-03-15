<?php

/**
 * This file contains the MPNSPayloadTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use Lunr\Vortex\MPNS\MPNSPriority;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MPNSPayload class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSPayload
 */
class MPNSPayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\MPNS\MPNSPayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray(): void
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
     * @covers       Lunr\Vortex\MPNS\MPNSPayload::escape_string
     */
    public function testEscapeString($string, $expected): void
    {
        $method = $this->get_accessible_reflection_method('escape_string');

        $this->assertEquals($expected, $method->invokeArgs($this->class, [ $string ]));
    }

    /**
     * Unit test data provider for strings and their expected escaped counterparts.
     *
     * @return array $strings Array of strings
     */
    public function stringProvider(): array
    {
        $strings   = [];
        $strings[] = [ 'string', 'string' ];
        $strings[] = [ '<string', '&lt;string' ];
        $strings[] = [ 'string>', 'string&gt;' ];
        $strings[] = [ '&string', '&amp;string' ];
        $strings[] = [ 'string‘s', 'string&apos;s' ];
        $strings[] = [ '“string“', '&quot;string&quot;' ];
        $strings[] = [ '<&“string‘s“>', '&lt;&amp;&quot;string&apos;s&quot;&gt;' ];

        return $strings;
    }

    /**
     * Unit test data provider for valid MPNS Priorities.
     *
     * @return array $priorities Array of MPNS priorities.
     */
    public function validPriorityProvider(): array
    {
        $priorities   = [];
        $priorities[] = [ MPNSPriority::DEFAULT ];
        $priorities[] = [ MPNSPriority::TILE_IMMEDIATELY ];
        $priorities[] = [ MPNSPriority::TOAST_IMMEDIATELY ];
        $priorities[] = [ MPNSPriority::RAW_IMMEDIATELY ];
        $priorities[] = [ MPNSPriority::TILE_WAIT_450 ];
        $priorities[] = [ MPNSPriority::TOAST_WAIT_450 ];
        $priorities[] = [ MPNSPriority::RAW_WAIT_450 ];
        $priorities[] = [ MPNSPriority::TILE_WAIT_900 ];
        $priorities[] = [ MPNSPriority::TOAST_WAIT_900 ];
        $priorities[] = [ MPNSPriority::RAW_WAIT_900 ];

        return $priorities;
    }

}

?>
