<?php

/**
 * This file contains the WNSToastPayloadTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSToastPayload;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSToastPayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSToastPayload
 */
abstract class WNSToastPayloadTest extends LunrBaseTest
{

    /**
     * Mock instance of the logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new WNSToastPayload($this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSToastPayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
