<?php

/**
 * This file contains the CurlBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains basic test methods for the Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
class CurlBaseTest extends CurlTest
{

    /**
     * Test that headers is an empty array by default.
     */
    public function testHeadersIsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('headers'));
    }

    /**
     * Test that options are set up correctly.
     */
    public function testOptionsSetupCorrectly()
    {
        $value = $this->get_reflection_property_value('options');

        $this->assertInternalType('array', $value);

        $this->assertArrayHasKey(CURLOPT_TIMEOUT, $value);
        $this->assertArrayHasKey(CURLOPT_RETURNTRANSFER, $value);
        $this->assertArrayHasKey(CURLOPT_FOLLOWLOCATION, $value);
        $this->assertArrayHasKey(CURLOPT_FAILONERROR, $value);

        $this->assertEquals(30, $value[CURLOPT_TIMEOUT]);
        $this->assertTrue($value[CURLOPT_RETURNTRANSFER]);
        $this->assertTrue($value[CURLOPT_FOLLOWLOCATION]);
        $this->assertTrue($value[CURLOPT_FAILONERROR]);
    }

    /**
     * Test that reset_options() resets the headers to an empty array.
     *
     * @covers Lunr\Network\Curl::reset_options
     */
    public function testResetOptionsResetsHeader()
    {
        $this->set_reflection_property_value('headers', NULL);
        $this->assertNull($this->get_reflection_property_value('headers'));

        $method = $this->get_accessible_reflection_method('reset_options');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('headers'));
    }

    /**
     * Test that reset_options() resets the options to default values.
     *
     * @covers Lunr\Network\Curl::reset_options
     */
    public function testResetOptionsResetsOptions()
    {
        $this->set_reflection_property_value('options', NULL);
        $this->assertNull($this->get_reflection_property_value('options'));

        $method = $this->get_accessible_reflection_method('reset_options');
        $method->invoke($this->class);

        $value = $this->get_reflection_property_value('options');

        $this->assertInternalType('array', $value);

        $this->assertArrayHasKey(CURLOPT_TIMEOUT, $value);
        $this->assertArrayHasKey(CURLOPT_RETURNTRANSFER, $value);
        $this->assertArrayHasKey(CURLOPT_FOLLOWLOCATION, $value);
        $this->assertArrayHasKey(CURLOPT_FAILONERROR, $value);

        $this->assertEquals(30, $value[CURLOPT_TIMEOUT]);
        $this->assertTrue($value[CURLOPT_RETURNTRANSFER]);
        $this->assertTrue($value[CURLOPT_FOLLOWLOCATION]);
        $this->assertTrue($value[CURLOPT_FAILONERROR]);
    }

}

?>
