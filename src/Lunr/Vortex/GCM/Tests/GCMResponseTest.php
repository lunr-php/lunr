<?php

/**
 * This file contains the GCMResponseBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
abstract class GCMResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the CurlResponse class.
     * @var Lunr\Network\CurlResponse
     */
    protected $curl_response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->curl_response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                                    ->disableOriginalConstructor()
                                    ->getMock();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->curl_response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
