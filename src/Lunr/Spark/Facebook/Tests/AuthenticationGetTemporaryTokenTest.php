<?php

/**
 * This file contains the AuthenticationGetTemporaryTokenTest class.
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

use Lunr\Spark\Facebook\Authentication;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Authentication.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Authentication
 */
class AuthenticationGetTemporaryTokenTest extends AuthenticationTest
{

    /**
     * Test that get_temporary_access_token() returns an empty string on request error.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsEmptyStringOnError()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token?';
        $params = 'client_id=Lunr&client_secret=Secret&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&code=Code';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url . $params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->assertSame('', $this->class->get_temporary_access_token());
    }

    /**
     * Test that get_temporary_access_token() stores the access token in the CAS.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresAccessTokenInCas()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token?';
        $params = 'client_id=Lunr&client_secret=Secret&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&code=Code';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url . $params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('access_token=Token&expires=100000'));

        $this->cas->expects($this->at(2))
                  ->method('add')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'), $this->equalTo('Token'));

        $this->class->get_temporary_access_token();
    }

    /**
     * Test that get_temporary_access_token() stores the token expiry time.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenStoresExpiryTime()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token?';
        $params = 'client_id=Lunr&client_secret=Secret&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&code=Code';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url . $params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('access_token=Token&expires=100000'));

        $this->class->get_temporary_access_token();

        $this->assertTrue($this->get_reflection_property_value('token_expires') <= time() + 100000);
    }

    /**
     * Test that get_temporary_access_token() returns the access token on success.
     *
     * @covers Lunr\Spark\Facebook\Authentication::get_temporary_access_token
     */
    public function testGetTemporaryAccessTokenReturnsAccessTokenOnSuccess()
    {
        $url    = 'https://graph.facebook.com/oauth/access_token?';
        $params = 'client_id=Lunr&client_secret=Secret&redirect_uri=http%3A%2F%2Flocalhost%2Fcontroller%2Fmethod%2F&code=Code';

        $this->cas->expects($this->at(0))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_id'))
                  ->will($this->returnValue('Lunr'));

        $this->cas->expects($this->at(1))
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('app_secret'))
                  ->will($this->returnValue('Secret'));

        $this->set_reflection_property_value('code', 'Code');

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url . $params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('access_token=Token&expires=100000'));

        $this->assertEquals('Token', $this->class->get_temporary_access_token());
    }

}

?>
