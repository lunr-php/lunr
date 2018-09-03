<?php

/**
 * This file contains the FeedGetPreviousDataTest class.
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
 * This class contains the tests for the Facebook Feed class.
 *
 * @covers Lunr\Spark\Facebook\Feed
 */
class FeedGetPreviousDataTest extends FeedTest
{

    /**
     * Test get_previous() uses fields for the request if they are set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousUsesFieldsIfSet()
    {
        $this->set_reflection_property_value('id', 'resource');
        $this->set_reflection_property_value('fields', [ 'email', 'user_likes' ]);

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'fields' => 'email,user_likes',
            'limit'  => 25,
            'since'  => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();
    }

    /**
     * Test get_previous() does not use fields for the request if they are not set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousDoesNotUseFieldsIfNotSet()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();
    }

    /**
     * Test get_previous() uses the access token for the request if it is set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousUsesAccessTokenIfPresent()
    {
        $this->set_reflection_property_value('id', 'resource');

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

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit'           => 25,
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
            'since'           => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();
    }

    /**
     * Test get_previous() does not use the access token for the request if it is not set.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousWhenAccessTokenNotPresent()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();
    }

    /**
     * Test that get_previous() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousSetsDataOnSuccessfulRequest()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();

        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_previous() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousSetsUserDataOnSuccessfulRequest()
    {
        $this->set_reflection_property_value('fetched_user_data', TRUE);

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/me/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{ "data": [ { "id":"1" } ] }';

        $this->class->get_previous();

        $this->assertContainsOnlyInstancesOf('Lunr\Spark\Facebook\Post', $this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_previous() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousSetsDataOnFailedRequest()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->class->get_previous();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_previous() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousSetsDataOnRequestError()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'limit' => 25,
            'since' => 0,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $this->class->get_previous();

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that get_previous() fetches permissions.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousFetchesPermissionsIfCheckPermissionsTrue()
    {
        $this->set_reflection_property_value('id', 'resource');
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

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
            'limit'           => 25,
            'since'           => 0,
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

        $this->class->get_previous();

        $this->assertPropertyEquals('permissions', [ 'email' => 1, 'user_likes' => 1 ]);
    }

    /**
     * Test that get_previous() does not fetch permissions.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_previous
     */
    public function testGetPreviousDoesNotFetchPermissionsIfCheckPermissionsFalse()
    {
        $this->set_reflection_property_value('id', 'resource');

        $this->cas->expects($this->exactly(4))
                  ->method('get')
                  ->will($this->onConsecutiveCalls('Token', 'Token', 'Proof'));

        $url    = 'https://graph.facebook.com/resource/feed';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
            'limit'           => 25,
            'since'           => 0,
        ];

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode([]);

        $this->class->get_previous();

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

}

?>
