<?php

/**
 * This file contains the PageGetDataTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Facebook Page class.
 *
 * @covers Lunr\Spark\Facebook\Page
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
                  ->method('get');

        $this->http->expects($this->never())
                   ->method('request');

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

        $url    = 'https://graph.facebook.com/page';
        $params = [ 'fields' => 'email,user_likes' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
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

        $url    = 'https://graph.facebook.com/page';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
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

        $url    = 'https://graph.facebook.com/page';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
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

        $url    = 'https://graph.facebook.com/page';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
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

        $url    = 'https://graph.facebook.com/page';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

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

        $url    = 'https://graph.facebook.com/page';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Page::get_data
     */
    public function testGetDataSetsDataOnRequestError()
    {
        $this->set_reflection_property_value('id', 'page');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/page';
        $params = [];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

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
                    'email'      => 1,
                    'user_likes' => 1,
                ],
            ],
        ];

        $this->cas->expects($this->exactly(6))
                  ->method('get')
                  ->will($this->onConsecutiveCalls('Token', 'Token', 'Proof', 'Token', 'Token', 'Token'));

        $url    = 'https://graph.facebook.com/page';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $url    = 'https://graph.facebook.com/me/permissions';
        $params = [ 'access_token' => 'Token' ];

        $this->http->expects($this->at(1))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

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

        $url    = 'https://graph.facebook.com/page';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode([]);

        $this->class->get_data();

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

}

?>
