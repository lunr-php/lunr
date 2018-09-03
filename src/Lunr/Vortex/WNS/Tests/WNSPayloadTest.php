<?php

/**
 * This file contains the WNSPayloadTest class.
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
class WNSPayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class = $this->getMockBuilder('Lunr\Vortex\WNS\WNSPayload')
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSPayload');
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
