<?php

/**
 * This file contains the SearchApiTest class.
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Requests_Exception_HTTP_400;
use Requests_Exception;

/**
 * This class contains the tests for the Search.
 *
 * @covers Lunr\Spark\Twitter\Search
 */
class SearchApiTest extends SearchTest
{

    /**
     * A sample http header array
     * @var array
     */
    protected $headers;

    /**
     * SearchApiTest constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->headers = [
            'Host'          => 'api.twitter.com',
            'Authorization' => 'Bearer BEARER TOKEN',
            'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
        ];
    }

    /**
     * Test that search_tweets() returns an empty array on request error.
     *
     * @covers Lunr\Spark\Twitter\Search::search_tweets
     */
    public function testSearchTweetsReturnsEmptyArrayOnError()
    {
        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $params = [
            'count'       => 5,
            'result_type' => 'recent',
            'q'           => '#testing',
        ];

        $options = [ 'verify' => TRUE ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'))
                  ->will($this->returnValue('BEARER TOKEN'));

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = '{"errors":[{"message":"Test twitter error","code":34}]}';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Invalid Input!')));

        $this->assertArrayEmpty($this->class->search_tweets($params));
    }

    /**
     * Test that search_tweets() returns an empty array on request failure.
     *
     * @covers Lunr\Spark\Twitter\Search::search_tweets
     */
    public function testSearchTweetsReturnsEmptyArrayOnFailure()
    {
        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $params = [
            'count'       => 5,
            'result_type' => 'recent',
            'q'           => '#testing',
        ];

        $options = [ 'verify' => TRUE ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'))
                  ->will($this->returnValue('BEARER TOKEN'));

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $this->assertArrayEmpty($this->class->search_tweets($params));
    }

    /**
     * Test that search_tweets() returns result tweets on success.
     *
     * @covers Lunr\Spark\Twitter\Search::search_tweets
     */
    public function testSearchTweetsReturnsResultTweets()
    {
        $url = 'https://api.twitter.com/1.1/search/tweets.json';

        $params = [
            'count'       => 5,
            'result_type' => 'recent',
            'q'           => '#testing',
        ];

        $options = [ 'verify' => TRUE ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'))
                  ->will($this->returnValue('BEARER TOKEN'));

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($this->headers), $this->equalTo($params), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{"statuses":[{"tweet":"Not a real tweet property and value"}]}';

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $result = $this->class->search_tweets($params);

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
    }

    /**
     * Tests that classify() returns null on empty input data.
     *
     * @covers Lunr\Spark\Twitter\Search::classify
     */
    public function testClassifyReturnsNullOnEmptyInput()
    {
        $method = $this->get_accessible_reflection_method('classify');

        $this->assertNull($method->invokeArgs($this->class, [ [] ]));
    }

    /**
     * Tests that classify() returns an array of tweets.
     *
     * @covers Lunr\Spark\Twitter\Search::classify
     */
    public function testClassifyReturnsArrayOfTweetsOnSuccess()
    {
        $result = [
            [ 'Foo' => 'Bar' ],
            [ 'Bar' => 'Foo' ],
        ];

        $method = $this->get_accessible_reflection_method('classify');

        $return = $method->invokeArgs($this->class, [ $result ]);

        $this->assertCount(2, $return);
        $this->assertInstanceOf('Lunr\Spark\Twitter\Tweet', $return[0]);
    }

}

?>
