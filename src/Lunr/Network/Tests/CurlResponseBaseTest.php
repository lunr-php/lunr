<?php

/**
 * This file contains the CurlResponseBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

/**
 * This class contains test methods for the Curl class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\CurlResponse
 */
class CurlResponseBaseTest extends CurlResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpError();
    }

    /**
     * Test that error_number is 0 by default.
     */
    public function testErrorNumberIsMinusOne()
    {
        $this->assertEquals(-1, $this->get_reflection_property_value('error_number'));
    }

    /**
     * Test that errmsg is an empty string by default.
     */
    public function testErrorMessageIsString()
    {
        $this->assertEquals('Could not set curl options!', $this->get_reflection_property_value('error_message'));
    }

    /**
     * Test that info is an empty array by default.
     */
    public function testInfoIsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('info'));
    }

    /**
     * Test that result is NULL by default.
     */
    public function testResultIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('result'));
    }

    /**
     * Test retrieving information for an existing key in $info.
     *
     * @covers Lunr\Network\CurlResponse::__get
     */
    public function testGetExistingInfoValue()
    {
        $this->set_reflection_property_value('info', ['key' => 'value']);

        $this->assertEquals('value', $this->class->key);
    }

    /**
     * Test retrieving information for a non-existing key in $info.
     *
     * @covers Lunr\Network\CurlResponse::__get
     */
    public function testGetNonExistingInfoValue()
    {
        $this->assertNull($this->class->key);
    }

}

?>
