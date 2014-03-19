<?php

/**
 * This file contains the APNSDispatcherSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

/**
 * This class contains tests for the setters of the APNSDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\APNS\APNSDispatcher
 */
class APNSDispatcherSetTest extends APNSDispatcherTest
{

    /**
     * Test that set_endpoint() sets the endpoint.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointSetsEndpoint()
    {
        $this->class->set_endpoint('endpoint');

        $this->assertPropertyEquals('endpoint', 'endpoint');
    }

    /**
     * Test the fluid interface of set_endpoint().
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoint('endpoint'));
    }

    /**
     * Test that set_payload() sets the payload.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_payload
     */
    public function testSetPayloadSetsPayload()
    {
        $payload = 'payload';
        $this->class->set_payload($payload);

        $this->assertPropertyEquals('payload', 'payload');
    }

    /**
     * Test the fluid interface of set_payload().
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_payload
     */
    public function testSetPayloadReturnsSelfReference()
    {
        $payload = 'payload';
        $this->assertEquals($this->class, $this->class->set_payload($payload));
    }

    /**
     * Test that set_certificate() sets the certificate.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_certificate
     */
    public function testSetCertificateSetsCertificate()
    {
        $certificate = 'certificate';
        $this->class->set_certificate($certificate);

        $this->assertPropertyEquals('certificate', 'certificate');
        $this->assertPropertyEquals('setup', FALSE);
    }

    /**
     * Test the fluid interface of set_certificate().
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_certificate
     */
    public function testSetCertificateReturnsSelfReference()
    {
        $certificate = 'certificate';
        $this->assertEquals($this->class, $this->class->set_certificate($certificate));
    }

    /**
     * Test that set_passphrase() sets the passphrase.
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_passphrase
     */
    public function testSetPassphraseSetsPassphrase()
    {
        $passphrase = 'passphrase';
        $this->class->set_passphrase($passphrase);

        $this->assertPropertyEquals('passphrase', 'passphrase');
        $this->assertPropertyEquals('setup', FALSE);
    }

    /**
     * Test the fluid interface of set_passphrase().
     *
     * @covers Lunr\Vortex\APNS\APNSDispatcher::set_passphrase
     */
    public function testSetPassphraseReturnsSelfReference()
    {
        $passphrase = 'passphrase';
        $this->assertEquals($this->class, $this->class->set_passphrase($passphrase));
    }

}

?>