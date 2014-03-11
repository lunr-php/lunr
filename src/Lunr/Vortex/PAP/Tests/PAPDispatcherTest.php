<?php

/**
 * This file contains the PAPDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PAP\PAPDispatcher;
// use Lunr\Vortex\PAP\PAPPriority;
// use Lunr\Vortex\PAP\PAPType;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PAPDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\PAP\PAPDispatcher
 */
abstract class PAPDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the Curl class.
     * @var Curl
     */
    protected $curl;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Reflection instance of the PAPDispatcher
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->curl       = $this->getMock('Lunr\Network\Curl');
        $this->logger     = $this->getMock('Psr\Log\LoggerInterface');

        $this->class = new PAPDispatcher($this->curl, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPDispatcher');
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
