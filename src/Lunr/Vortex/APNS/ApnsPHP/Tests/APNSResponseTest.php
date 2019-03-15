<?php

/**
 * This file contains the APNSResponseTest class.
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Halo\LunrBaseTest;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSResponse class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
abstract class APNSResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of an APNS Message class.
     * @var ApnsPHP\Message
     */
    protected $apns_message;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->apns_message = $this->getMockBuilder('ApnsPHP_Message')
                                   ->disableOriginalConstructor()
                                   ->getMock();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}
