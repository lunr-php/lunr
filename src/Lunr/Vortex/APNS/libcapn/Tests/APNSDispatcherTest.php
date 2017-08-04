<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\libcapn\Tests;

use Lunr\Vortex\APNS\libcapn\APNSDispatcher;
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
     * Runkit simulation code for returning TRUE.
     * @var String
     */
    const APN_RETURN_TRUE = 'return TRUE;';

    /**
     * List of the php_apn functions we are mocking.
     * @var LoggerInterface
     */
    protected $apn_functions;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        if (!extension_loaded('apn'))
        {
            $this->markTestSkipped('Extension apn is required.');
            return;
        }

        $this->apn_functions = [
            'apn_set_certificate',
            'apn_set_private_key',
            'apn_payload_add_token',
            'apn_payload_init',
            'apn_payload_set_body',
            'apn_payload_set_sound',
            'apn_payload_set_badge',
            'apn_payload_add_custom_property',
            'apn_connect',
            'apn_send',
            'apn_close',
            'apn_payload_free',
            'apn_set_mode',
        ];

        $this->mock_function('apn_init', self::APN_RETURN_TRUE);

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->class = new APNSDispatcher($this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\libcapn\APNSDispatcher');

        $this->unmock_function('apn_init');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        $this->mock_function('apn_free', self::APN_RETURN_TRUE);

        unset($this->logger);
        unset($this->class);
        unset($this->reflection);

        $this->unmock_function('apn_free');
    }

}

?>
