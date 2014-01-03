<?php

/**
 * This file contains the PageGetDataTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\Facebook\Page;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Facebook Page class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Page
 */
class PageGetDataTest extends PageTest
{

    /**
     * Test get_data() does not perform an API call if the page ID is not set.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataDoesNotCallApiIfPageIDNotSet()
    {
        $this->cas->expects($this->never())
                  ->method('__get');

        $this->curl->expects($this->never())
                   ->method('get_request');

        $this->class->get_data();
    }

    /**
     * Test get_data() uses fields for the request if they are set.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataUsesFieldsIfSet()
    {
        $this->set_reflection_property_value('id', 'page');
        $this->set_reflection_property_value('fields', [ 'email', 'user_likes' ]);

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?fields=email%2Cuser_likes'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use fields for the request if they are not set.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataDoesNotUseFieldsIfNotSet()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() uses the access token for the request if it is set.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataUsesAccessTokenIfPresent()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $this->cas->expects($this->at(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret_proof'))
                  ->will($this->returnValue('Proof'));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?access_token=Token&appsecret_proof=Proof'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test get_data() does not use the access token for the request if it is not set.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataWhenAccessTokenNotPresent()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?'))
                   ->will($this->returnValue($this->response));

        $this->class->get_data();
    }

    /**
     * Test that get_data() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataSetsDataOnSuccessfulRequest()
    {
        $this->set_reflection_property_value('id', 'page');

        $data = [ 'name' => 'Foo' ];

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with('http_code')
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($data)));

        $this->class->get_data();

        $this->assertPropertySame('data', $data);
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataSetsDataOnFailedRequest()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/page?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with('http_code')
                       ->will($this->returnValue(400));

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() fetches permissions.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataFetchesPermissionsIfCheckPermissionsTrue()
    {
        $this->set_reflection_property_value('id', 'page');
        $this->set_reflection_property_value('check_permissions', TRUE);

        $data = [
            'data' => [
                0 => [
                    'email' => 1,
                    'user_likes' => 1
                ]
            ]
        ];

        $this->cas->expects($this->exactly(6))
                  ->method('get')
                  ->will($this->onConsecutiveCalls('Token', 'Token', 'Proof', 'Token', 'Token', 'Token'));

        $this->curl->expects($this->exactly(2))
                   ->method('get_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->exactly(2))
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->exactly(2))
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($data)));

        $this->class->get_data();

        $this->assertPropertyEquals('permissions', [ 'email' => 1, 'user_likes' => 1 ]);
    }

    /**
     * Test that get_data() does not fetch permissions.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataDoesNotFetchPermissionsIfCheckPermissionsFalse()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->exactly(4))
                  ->method('get')
                  ->will($this->onConsecutiveCalls('Token', 'Token', 'Proof'));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode([])));

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

}

?>
