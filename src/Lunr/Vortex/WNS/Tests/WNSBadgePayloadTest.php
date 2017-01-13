<?php

/**
 * This file contains the WNSBadgePayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSBadgePayload;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
abstract class WNSBadgePayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class = new WNSBadgePayload();

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSBadgePayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
