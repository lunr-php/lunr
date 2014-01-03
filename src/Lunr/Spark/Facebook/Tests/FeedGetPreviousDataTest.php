<?php

/**
 * This file contains the FeedGetPreviousDataTest class.
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

use ReflectionClass;

/**
 * This class contains the tests for the Facebook Feed class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Feed
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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0&fields=email%2Cuser_likes'))
                   ->will($this->returnValue($this->response));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0'))
                   ->will($this->returnValue($this->response));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0&access_token=Token&appsecret_proof=Proof'))
                   ->will($this->returnValue($this->response));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0'))
                   ->will($this->returnValue($this->response));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with('http_code')
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{ "data": [ { "id":"1" } ] }'));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/me/feed?limit=25&since=0'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with('http_code')
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{ "data": [ { "id":"1" } ] }'));

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

        $this->curl->expects($this->at(1))
                   ->method('get_request')
                   ->with($this->equalTo('https://graph.facebook.com/resource/feed?limit=25&since=0'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with('http_code')
                       ->will($this->returnValue(400));

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

        $this->class->get_previous();

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

}

?>
