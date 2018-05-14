<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\libcapn\APNSDispatcher
 */
abstract class APNSDispatcherTest extends LunrBaseTest
{

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of an APNS Push class.
     * @var \ApnsPHP_Push
     */
    protected $apns_push;

    /**
     * Mock instance of an APNS Message class.
     * @var \ApnsPHP_Message
     */
    protected $apns_message;

    /**
     * Mock instance of the APNS Payload class.
     * @var \Lunr\Vortex\APNS\APNSPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->apns_push = $this->getMockBuilder('ApnsPHP_Push')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->apns_message = $this->getMockBuilder('ApnsPHP_Message')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\APNS\APNSPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher')
                            ->setConstructorArgs([ $this->logger, $this->apns_push ])
                            ->setMethods([ 'get_new_apns_message' ])
                            ->setMockClassName('APNSDispatcher_Mock')
                            ->getMock();

        $this->class->expects($this->any())
                    ->method('get_new_apns_message')
                    ->willReturn($this->apns_message);

        $this->reflection = new ReflectionClass('APNSDispatcher_Mock');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->apns_push);
        unset($this->apns_message);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
