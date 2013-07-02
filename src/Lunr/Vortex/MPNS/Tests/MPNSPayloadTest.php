<?php

/**
 * This file contains the MPNSPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MPNSPayload class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSPayload
 */
class MPNSPayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\MPNS\MPNSPayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

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
     * @param String $string   Unescaped base string
     * @param String $expected Expected escaped string
     *
     * @dataProvider stringProvider
     * @covers       Lunr\Vortex\MPNS\MPNSPayload::escape_string
     */
    public function testEscapeString($string, $expected)
    {
        $method = $this->get_accessible_reflection_method('escape_string');

        $this->assertEquals($expected, $method->invokeArgs($this->class, [$string]));
    }

    /**
     * Unit test data provider for strings and their expected escaped counterparts.
     *
     * @return array $strings Array of strings
     */
    public function stringProvider()
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

}

?>
