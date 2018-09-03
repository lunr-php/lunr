<?php

/**
 * This file contains the ApiFetchDataTest class.
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
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Api
 */
class ApiFetchDataTest extends ApiTest
{

    /**
     * Test fetch_data() sets used_access_token to TRUE when using an access token for the request.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataSetsUsedAccessTokenTrueWhenUsingAccessToken()
    {
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

        $this->http->expects($this->any())
                   ->method('request')
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertTrue($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test fetch_data() sets used_access_token to FALSE when not using an access token for the request.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataSetsUsedAccessTokenFalseWhenNotUsingAccessToken()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $this->http->expects($this->any())
                   ->method('request')
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertFalse($this->get_reflection_property_value('used_access_token'));
    }

    /**
     * Test fetch_data() uses fields for the request if they are set.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataUsesFieldsIfSet()
    {
        $this->set_reflection_property_value('fields', [ 'email', 'user_likes' ]);

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url    = 'http://localhost';
        $params = [ 'fields' => 'email,user_likes' ];

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test fetch_data() does not use fields for the request if they are not set.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataDoesNotUseFieldsIfNotSet()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url = 'http://localhost';

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test fetch_data() uses the access token for the request if it is set.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataUsesAccessTokenIfPresent()
    {
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

        $url    = 'http://localhost';
        $params = [
            'access_token'    => 'Token',
            'appsecret_proof' => 'Proof',
        ];

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test fetch_data() does not use the access token for the request if it is not set.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataWhenAccessTokenNotPresent()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url = 'http://localhost';

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that fetch_data() sets data when request was successful.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataSetsDataOnSuccessfulRequest()
    {
        $data = [ 'name' => 'Foo' ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url = 'http://localhost';

        $this->http->expects($this->at(0))
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($data);

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertPropertySame('data', $data);
    }

    /**
     * Test that fetch_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataSetsDataOnFailedRequest()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

    /**
     * Test that fetch_data() sets data when request was not successful.
     *
     * @covers Lunr\Spark\Facebook\Api::fetch_data
     */
    public function testFetchDataSetsDataOnRequestError()
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('facebook'), $this->equalTo('access_token'))
                  ->will($this->returnValue(NULL));

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url/';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Not Found!')));

        $method = $this->get_accessible_reflection_method('fetch_data');
        $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertArrayEmpty($this->get_reflection_property_value('data'));
    }

}

?>
