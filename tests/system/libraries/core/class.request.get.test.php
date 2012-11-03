<?php

/**
 * This file contains the RequestGetTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;
use \ReflectionClass;

/**
 * Tests for getting stored superglobal values.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Request
 */
class RequestGetTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpFilled();
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreBasePath
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreDomain
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStorePort
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStorePortIfHttpsIsset
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreBaseUrl
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreSpecialGetValues
     * @dataProvider properRequestValueProvider
     * @covers       Lunr\Libraries\Core\Request::__get
     */
    public function test_magic_get_method($key, $value)
    {
        $this->assertEquals($value, $this->request->$key);
    }

    /**
     * Test that the hostname value is returned correctly by the magic get method.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     */
    public function testGetHostname()
    {
        $this->assertEquals('Lunr', $this->request->host);
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreValidGetValues
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Libraries\Core\Request::get_get_data
     */
    public function test_get_get_data($value, $key)
    {
        $this->assertEquals($value, $this->request->get_get_data($key));
    }

    /**
     * Test getting POST data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreValidPostValues
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Libraries\Core\Request::get_post_data
     */
    public function test_get_post_data($value, $key)
    {
        $this->assertEquals($value, $this->request->get_post_data($key));
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestStoreTest::testStoreValidCookieValues
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Libraries\Core\Request::get_cookie_data
     */
    public function test_get_cookie_data($value, $key)
    {
        $this->assertEquals($value, $this->request->get_cookie_data($key));
    }

    /**
     * Test getting valid json data from post.
     *
     * @param String $index the expected value as well as the index
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestBaseTest::testSetJsonEnums
     * @depends      test_get_post_data
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Libraries\Core\Request::get_json_from_post
     */
    public function test_get_valid_json_from_post($index)
    {
        $this->assertEquals($index, $this->request->get_json_from_post($index));
    }

    /**
     * Test getting non existing json data from post returns NULL.
     *
     * @param String $index the expected value as well as the index
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestBaseTest::testSetJsonEnums
     * @depends      test_get_post_data
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Libraries\Core\Request::get_json_from_post
     */
    public function test_get_non_existing_json_from_post_is_null($index)
    {
        $this->assertNull($this->request->get_json_from_post($index));
    }

    /**
     * Test getting valid json data from get.
     *
     * @param String $index the expected value as well as the index
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestBaseTest::testSetJsonEnums
     * @depends      test_get_get_data
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Libraries\Core\Request::get_json_from_get
     */
    public function test_get_valid_json_from_get($index)
    {
        $this->assertEquals($index, $this->request->get_json_from_get($index));
    }

    /**
     * Test getting non existing json data from get returns NULL.
     *
     * @param String $index the expected value as well as the index
     *
     * @runInSeparateProcess
     *
     * @depends      Lunr\Libraries\Core\RequestBaseTest::testSetJsonEnums
     * @depends      test_get_get_data
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Libraries\Core\Request::get_json_from_get
     */
    public function test_get_non_existing_json_from_get_is_null($index)
    {
        $this->assertNull($this->request->get_json_from_get($index));
    }

}

?>
