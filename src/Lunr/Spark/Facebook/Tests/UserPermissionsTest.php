<?php

/**
 * This file contains the UserPermissionsTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Lunr\Spark\DataError;
use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Facebook User class.
 *
 * @covers Lunr\Spark\Facebook\User
 */
class UserPermissionsTest extends UserTest
{

    /**
     * Test that get_permissions() does not get permissions if the access token is null.
     *
     * @covers Lunr\Spark\Facebook\User::get_permissions
     */
    public function testGetPermissionsDoesNotGetPermissionsIfAccessTokenIsNull(): void
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $method = $this->get_accessible_reflection_method('get_permissions');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that get_permissions() does not get permissions with an app access token.
     *
     * @covers Lunr\Spark\Facebook\User::get_permissions
     */
    public function testGetPermissionsDoesNotGetPermissionsWithAnAppAccessToken(): void
    {
        $this->cas->expects($this->exactly(2))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('App|Only'));

        $method = $this->get_accessible_reflection_method('get_permissions');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that get_permissions() sets permissions on success.
     *
     * @covers Lunr\Spark\Facebook\User::get_permissions
     */
    public function testGetPermissionsSetsPermissionsOnSuccess(): void
    {
        $data = [
            'data' => [
                0 => [
                    'email'      => 1,
                    'user_likes' => 1,
                ],
            ],
        ];

        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $url    = 'https://graph.facebook.com/me/permissions';
        $params = [ 'access_token' => 'Token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

        $method = $this->get_accessible_reflection_method('get_permissions');
        $method->invoke($this->class);

        $this->assertPropertySame('permissions', $data['data'][0]);
    }

    /**
     * Test that get_permissions() does not set permissions on error.
     *
     * @covers Lunr\Spark\Facebook\User::get_permissions
     */
    public function testGetPermissionsSetsPermissionsEmptyOnError(): void
    {
        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $url    = 'https://graph.facebook.com/me/permissions';
        $params = [ 'access_token' => 'Token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->url         = 'https://graph.facebook.com/me/permissions';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $body = [
            'error' => [
                'message' => 'Some error',
                'code'    => 400,
                'type'    => 'foo'
            ],
        ];

        $this->response->body = json_encode($body);

        $context = [
            'message' => 'Some error',
            'code'    => 400,
            'type'    => 'foo',
            'request' => 'https://graph.facebook.com/me/permissions',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);

        $method = $this->get_accessible_reflection_method('get_permissions');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that get_permissions() does not set permissions on failure.
     *
     * @covers Lunr\Spark\Facebook\User::get_permissions
     */
    public function testGetPermissionsSetsPermissionsEmptyOnFailure(): void
    {
        $this->cas->expects($this->exactly(3))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue('Token'));

        $url    = 'https://graph.facebook.com/me/permissions';
        $params = [ 'access_token' => 'Token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $method = $this->get_accessible_reflection_method('get_permissions');
        $method->invoke($this->class);

        $this->assertArrayEmpty($this->get_reflection_property_value('permissions'));
    }

    /**
     * Test that is_permissions_granted() returns TRUE when permissions are granted.
     *
     * @param string|array $permissions Set of permissions to check for.
     *
     * @dataProvider validPermissionsProvider
     * @covers       Lunr\Spark\Facebook\User::is_permission_granted
     */
    public function testIsPermissionGrantedReturnsTrueIfPermissionsGranted($permissions): void
    {
        $granted = [ 'email' => 1, 'user_likes' => 1 ];

        $this->set_reflection_property_value('permissions', $granted);

        $method = $this->get_accessible_reflection_method('is_permission_granted');

        $this->assertTrue($method->invokeArgs($this->class, [ $permissions ]));
    }

    /**
     * Test that is_permissions_granted() returns FALSE when permissions are not granted.
     *
     * @param string|array $permissions Set of permissions to check for.
     *
     * @dataProvider invalidPermissionsProvider
     * @covers       Lunr\Spark\Facebook\User::is_permission_granted
     */
    public function testIsPermissionGrantedReturnsFalseIfPermissionsNotGranted($permissions): void
    {
        $granted = [ 'email' => 1, 'user_likes' => 1 ];

        $this->set_reflection_property_value('permissions', $granted);

        $method = $this->get_accessible_reflection_method('is_permission_granted');

        $this->assertFalse($method->invokeArgs($this->class, [ $permissions ]));
    }

    /**
     * Test that check_item_access() returns Not Available if permissions are granted.
     *
     * @param string|array $permissions Set of permissions to check for.
     *
     * @dataProvider validPermissionsProvider
     * @covers       Lunr\Spark\Facebook\User::check_item_access
     */
    public function testCheckItemAccessReturnsNotAvailableIfPermissionsGranted($permissions): void
    {
        $granted = [ 'email' => 1, 'user_likes' => 1 ];

        $this->set_reflection_property_value('permissions', $granted);

        $method = $this->get_accessible_reflection_method('check_item_access');

        $this->assertSame(DataError::NOT_AVAILABLE, $method->invokeArgs($this->class, [ 'item', $permissions ]));
    }

    /**
     * Test that check_item_access() returns Access Denied if permissions are not granted.
     *
     * @param string|array $permissions Set of permissions to check for.
     *
     * @dataProvider invalidPermissionsProvider
     * @covers       Lunr\Spark\Facebook\User::check_item_access
     */
    public function testCheckItemAccessReturnsAccessDeniedIfPermissionsNotGranted($permissions): void
    {
        $granted = [ 'email' => 1, 'user_likes' => 1 ];

        $this->set_reflection_property_value('permissions', $granted);

        $method = $this->get_accessible_reflection_method('check_item_access');

        $this->assertSame(DataError::ACCESS_DENIED, $method->invokeArgs($this->class, [ 'item', $permissions ]));
    }

    /**
     * Test that check_item_access() logs a warning if permissions are not granted.
     *
     * @param string|array $permissions Set of permissions to check for.
     * @param string       $info        Missing permission info.
     *
     * @dataProvider invalidPermissionsProvider
     * @covers       Lunr\Spark\Facebook\User::check_item_access
     */
    public function testCheckItemAccessLogsWarningIfPermissionsNotGranted($permissions, $info): void
    {
        $granted = [ 'email' => 1, 'user_likes' => 1 ];

        $this->set_reflection_property_value('permissions', $granted);

        $context = [ 'field' => 'item', 'permission' => $info ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Access to "{field}" requires "{permission}" permission.'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('check_item_access');

        $method->invokeArgs($this->class, [ 'item', $permissions ]);
    }

}

?>
