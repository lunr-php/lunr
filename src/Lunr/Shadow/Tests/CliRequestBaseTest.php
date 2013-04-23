<?php

/**
 * This file contains the CliRequestBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for the CliRequest class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Shadow\CliRequest
 */
class CliRequestBaseTest extends CliRequestTest
{

    /**
     * Tests that the ast inits with an array.
     *
     * @covers Lunr\Shadow\CliRequest::__construct
     */
    public function testAstInitsWithArray()
    {
        $value = $this->get_reflection_property_value('ast');

        $this->assertInternalType('array', $value);
    }

    /**
     * Tests that get inits with an empty array.
     *
     * @covers Lunr\Shadow\CliRequest::__construct
     */
    public function testGetInitsWithEmptyArray()
    {
        $value = $this->get_reflection_property_value('get');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that post inits with an empty array.
     *
     * @covers Lunr\Shadow\CliRequest::__construct
     */
    public function testPostInitsWithEmptyArray()
    {
        $value = $this->get_reflection_property_value('post');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that post inits with an empty array.
     *
     * @covers Lunr\Shadow\CliRequest::__construct
     */
    public function testCookieInitsWithEmptyArray()
    {
        $value = $this->get_reflection_property_value('cookie');

        $this->assertArrayEmpty($value);
    }

    /**
     * Tests that store_get stores default values.
     *
     * @param String $request_key The request key to test.
     * @param String $config_key  The configuration key to match.
     *
     * @depends      Lunr\EnvironmentTest::testRunkit
     * @dataProvider requestConfigKeyProvider
     * @covers       Lunr\Shadow\CliRequest::store_default
     */
    public function testStoreDefaultInitsWithConfigurationValues($request_key, $config_key)
    {
        $request = $this->get_reflection_property_value('request');

        $this->assertEquals($request[$request_key], $this->configuration[$config_key]);
    }

    /**
     * Tests that store_get inits params with empty array.
     *
     * @covers Lunr\Shadow\CliRequest::store_default
     */
    public function testStoreDefaultInitsParamsAsEmptyArray()
    {
        $request = $this->get_reflection_property_value('request');

        $this->assertArrayEmpty($request['params']);
    }

    /**
     * Check that json_enums is empty by default.
     *
     * @covers Lunr\Shadow\CliRequest::__construct
     */
    public function testJsonEnumsEmpty()
    {
        $json_enums = $this->get_reflection_property_value('json_enums');

        $this->assertArrayEmpty($json_enums);
    }

    /**
     * Test setting json enums.
     *
     * @depends testJsonEnumsEmpty
     * @covers   Lunr\Shadow\CliRequest::set_json_enums
     */
    public function testSetJsonEnums()
    {
        $JSON = $this->get_json_enums();

        $this->class->set_json_enums($JSON);

        $json_enums = $this->get_reflection_property_value('json_enums');

        $this->assertEquals($JSON, $json_enums);
        $this->assertSame($JSON, $json_enums);
    }

}

?>
