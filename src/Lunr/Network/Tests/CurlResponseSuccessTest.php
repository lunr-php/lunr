<?php

/**
 * This file contains the CurlResponseSuccessTest class.
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
class CurlResponseSuccessTest extends CurlResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test that error_number is 10 by default.
     */
    public function testErrorNumberIsTen()
    {
        $this->assertEquals(10, $this->get_reflection_property_value('error_number'));
    }

    /**
     * Test that errmsg is an empty string by default.
     */
    public function testErrorMessageIsString()
    {
        $this->assertEquals('error', $this->get_reflection_property_value('error_message'));
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
    public function testResultIsValue()
    {
        $this->assertEquals('Result', $this->get_reflection_property_value('result'));
    }

    /**
     * Test getting the result.
     *
     * @covers Lunr\Network\CurlResponse::get_result
     */
    public function testGetResult()
    {
        $this->assertEquals('Result', $this->class->get_result());
    }

}

?>
