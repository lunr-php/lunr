<?php

/**
 * This file contains the APNSDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

use Lunr\Vortex\APNS\APNSType;
use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\APNSDispatcher
 */
class APNSDispatcherBaseTest extends APNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoint is set to an empty array by default.
     */
    public function testEndpointIsEmptyArray()
    {
        $this->assertPropertyEquals('endpoint', '');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEquals('payload', '');
    }

    /**
     * Test that the certificate is set to an empty string by default.
     */
    public function testCertificateIsEmptyString()
    {
        $this->assertPropertyEquals('certificate', '');
    }

    /**
     * Test that the passphrase is set to an empty string by default.
     */
    public function testPassphraseIsEmptyString()
    {
        $this->assertPropertyEquals('passphrase', '');
    }

    /**
     * Test that the passphrase is set to an empty string by default.
     *
     * @requires extension apn
     */
    public function testModeIsProduction()
    {
        $this->assertPropertyEquals('mode', APN_PRODUCTION);
    }

    /**
     * Test that the setup flag is set to FALSE by default.
     */
    public function testSetupIsFalse()
    {
        $this->assertFalse($this->get_reflection_property_value('setup'));
    }

    /**
     * Test that the apn reference is set correctly.
     */
    public function testApnIsSetCorrectly()
    {
        $this->assertTrue($this->get_reflection_property_value('apn'));
    }

}

?>
