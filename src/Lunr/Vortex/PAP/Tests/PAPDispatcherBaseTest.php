<?php

/**
 * This file contains the PAPDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the PAPDispatcher class.
 *
 * @covers Lunr\Vortex\PAP\PAPDispatcher
 */
class PAPDispatcherBaseTest extends PAPDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoint is set to an empty array by default.
     */
    public function testEndpointIsEmptyArray()
    {
        $this->assertPropertyEmpty('endpoint');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEmpty('payload');
    }

    /**
     * Test that the auth_token is set to an empty string by default.
     */
    public function testAuthTokenIsEmptyString()
    {
        $this->assertPropertyEmpty('auth_token');
    }

    /**
     * Test that the password is set to an empty string by default.
     */
    public function testPasswordIsEmptyString()
    {
        $this->assertPropertyEmpty('password');
    }

    /**
     * Test that the content provider id is set to an empty string by default.
     */
    public function testCidIsEmptyString()
    {
        $this->assertPropertyEmpty('cid');
    }

    /**
     * Test that the deliver before timestamp is set to an empty string by default.
     */
    public function testDeliverBeforeIsEmptyString()
    {
        $this->assertPropertyEmpty('deliverbefore');
    }

    /**
     * Test that the push id is set to an empty string by default.
     */
    public function testPushIdIsEmptyString()
    {
        $this->assertPropertyEmpty('push_id');
    }

    /**
     * Test that the passed Curl object is set correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertSame($this->curl, $this->get_reflection_property_value('curl'));
    }

    /**
     * Test that construct_pap_control_xml() creates an XML with empty fields when the push_id & private properties are empty.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::construct_pap_control_xml
     */
    public function testConstructControlXMLWithEmptyInputConstructsEmptyXML()
    {
        $method = $this->reflection->getMethod('construct_pap_control_xml');
        $method->setAccessible(TRUE);

        $control_xml = $method->invoke($this->class);

        $xml_file = file_get_contents(TEST_STATICS . '/Vortex/pap_request_control_empty.xml');

        $this->assertEquals($control_xml, $xml_file);
    }

    /**
     * Test that construct_pap_control_xml() creates a proper XML when the push_id & private properties are present.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::construct_pap_control_xml
     */
    public function testConstructControlXMLConstructsXMLCorrectly()
    {
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', 'endpoint12345');

        $method = $this->reflection->getMethod('construct_pap_control_xml');
        $method->setAccessible(TRUE);

        $control_xml = $method->invoke($this->class);

        $xml_file = file_get_contents(TEST_STATICS . '/Vortex/pap_request_control.xml');

        $this->assertEquals($control_xml, $xml_file);
    }

    /**
     * Test that construct_pap_data() creates a proper XML when the push_id & private properties are present.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::construct_pap_data
     */
    public function testConstructPAPDataConstructsHeadersCorrectly()
    {
        $this->mock_function('microtime', 'return 12345;');

        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('payload', '{"message":"test"}');

        $method = $this->reflection->getMethod('construct_pap_data');
        $method->setAccessible(TRUE);

        $request_headers = $method->invoke($this->class);

        $request_file = file_get_contents(TEST_STATICS . '/Vortex/pap_request_custom_headers.txt');

        $this->assertEquals($request_headers, $request_file);

        $this->unmock_function('microtime');
    }

}

?>
