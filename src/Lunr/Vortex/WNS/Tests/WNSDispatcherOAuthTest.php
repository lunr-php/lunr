<?php
/**
 * This file contains the WNSDispatcherOAuthTest Class
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * Class WNSDispatcherOAuthTest tests the Authentication to the WNS Server
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
class WNSDispatcherOAuthTest extends WNSDispatcherTest
{

    /**
     * Prepares the configuration for a $config call.
     *
     * @param string $client_id     The client_id you want returned from the config
     * @param string $client_secret The client_secret you want returned
     *
     * @return void
     */
    private function expectFromConfig($client_id, $client_secret)
    {

        $this->set_reflection_property_value('client_id', $client_id);
        $this->set_reflection_property_value('client_secret', $client_secret);

    }

    /**
     * Test that using get_oauth_token queries with config variables.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_oauth_token
     */
    public function testGetOathMakesCorrectRequest()
    {
        $request_post = http_build_query([
            'grant_type'    => 'client_credentials',
            'client_id'     => '012345',
            'client_secret' => '012345678',
            'scope'         => 'notify.windows.com',
        ]);

        $this->expectFromConfig('012345', '012345678');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('https://login.live.com/accesstoken.srf'), $this->equalTo($request_post))
                   ->will($this->returnValue($this->curlresponse));

        $this->curlresponse->expects($this->once())
                           ->method('get_result')
                           ->will($this->returnValue('{"access_token":"access_token"}'));

        $this->class->get_oauth_token();
    }

    /**
     * Test that using get_oauth_token responds with FALSE if the response is erroneous.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_oauth_token
     */
    public function testGetOathRespondsFalseIfErrorCurl()
    {
        $request_post = http_build_query([
            'grant_type'    => 'client_credentials',
            'client_id'     => '012345',
            'client_secret' => '012345678',
            'scope'         => 'notify.windows.com',
        ]);

        $this->expectFromConfig('012345', '012345678');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('https://login.live.com/accesstoken.srf'), $this->equalTo($request_post))
                   ->will($this->returnValue($this->curlresponse));

        $this->curlresponse->expects($this->never())
                           ->method('get_result');

        $this->curlresponse->expects($this->once())
                           ->method('__get')
                           ->with($this->equalTo('error_number'))
                           ->will($this->returnValue(5));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Requesting token failed: No response');

        $this->assertFalse($this->class->get_oauth_token());
    }

    /**
     * Test that using get_oauth_token responds with FALSE if the response is invalid JSON.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_oauth_token
     */
    public function testGetOathRespondsFalseIfInvalidJSON()
    {
        $request_post = http_build_query([
                                             'grant_type'    => 'client_credentials',
                                             'client_id'     => '012345',
                                             'client_secret' => '012345678',
                                             'scope'         => 'notify.windows.com',
                                         ]);

        $this->expectFromConfig('012345', '012345678');


        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('https://login.live.com/accesstoken.srf'), $this->equalTo($request_post))
                   ->will($this->returnValue($this->curlresponse));

        $this->curlresponse->expects($this->once())
                           ->method('get_result')
                           ->will($this->returnValue('HELLO I\'m an invalid JSON object'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Requesting token failed: Malformed JSON response');

        $this->assertFalse($this->class->get_oauth_token());
    }

    /**
     * Test that using get_oauth_token responds with FALSE if the response is incomplete JSON.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_oauth_token
     */
    public function testGetOathRespondsFalseIfIncompleteJSON()
    {
        $request_post = http_build_query([
                                             'grant_type'    => 'client_credentials',
                                             'client_id'     => '012345',
                                             'client_secret' => '012345678',
                                             'scope'         => 'notify.windows.com',
                                         ]);

        $this->expectFromConfig('012345', '012345678');


        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('https://login.live.com/accesstoken.srf'), $this->equalTo($request_post))
                   ->will($this->returnValue($this->curlresponse));

        $this->curlresponse->expects($this->once())
                           ->method('get_result')
                           ->will($this->returnValue('{"Message": "HELLO I\'m an invalid JSON object"}'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Requesting token failed: Not a valid JSON response');

        $this->assertFalse($this->class->get_oauth_token());
    }

    /**
     * Test that using get_oauth_token response.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_oauth_token
     */
    public function testGetOathRespondsCorrectly()
    {
        $request_post = http_build_query([
            'grant_type'    => 'client_credentials',
            'client_id'     => '012345',
            'client_secret' => '012345678',
            'scope'         => 'notify.windows.com',
        ]);

        $this->expectFromConfig('012345', '012345678');


        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('https://login.live.com/accesstoken.srf'), $this->equalTo($request_post))
                   ->will($this->returnValue($this->curlresponse));

        $this->curlresponse->expects($this->once())
                           ->method('get_result')
                           ->will($this->returnValue('{"access_token":"access_token"}'));

        $this->assertSame('access_token', $this->class->get_oauth_token());
    }

}
