<?php

/**
 * This file contains the SearchApiTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

/**
 * This class contains the tests for the Search.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Spark\Twitter\Search
 */
class SearchApiTest extends SearchTest
{

    /**
     * A sample curl header array
     * @var array
     */
    protected $header;

    /**
     * SearchApiTest constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->header = [
            'Host: api.twitter.com',
            'Authorization: Bearer BEARER TOKEN',
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        ];
    }

    /**
     * Test that search_tweets() returns an empty array on request error.
     *
     * @covers Lunr\Spark\Twitter\Search::search_tweets
     */
    public function testSearchTweetsReturnsEmptyArrayOnError()
    {
        $url    = 'https://api.twitter.com/1.1/search/tweets.json';
        $params = [
            'count' => 5,
            'result_type' => 'recent',
            'q' => '#testing'
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'))
                  ->will($this->returnValue('BEARER TOKEN'));

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_ENCODING'), $this->equalTo('gzip'));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo($this->header));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"errors":[{"message":"Test twitter error","code":34}]}'));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->assertArrayEmpty($this->class->search_tweets($params));
    }

    /**
     * Test that search_tweets() returns result tweets on success.
     *
     * @covers Lunr\Spark\Twitter\Search::search_tweets
     */
    public function testSearchTweetsReturnsResultTweets()
    {
        $url    = 'https://api.twitter.com/1.1/search/tweets.json';
        $params = [
            'count' => 5,
            'result_type' => 'recent',
            'q' => '#testing'
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('twitter'), $this->equalTo('bearer_token'))
                  ->will($this->returnValue('BEARER TOKEN'));

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_ENCODING'), $this->equalTo('gzip'));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo($this->header));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"statuses":[{"tweet":"Not a real tweet property and value"}]}'));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

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

        $this->assertNull($method->invokeArgs($this->class, [[]]));
    }

    /**
     * Tests that classify() returns an array of tweets.
     *
     * @covers Lunr\Spark\Twitter\Search::classify
     */
    public function testClassifyReturnsArrayOfTweetsOnSuccess()
    {
        $result = [
            ['Foo' => 'Bar'],
            ['Bar' => 'Foo']
        ];

        $method = $this->get_accessible_reflection_method('classify');

        $return = $method->invokeArgs($this->class, [$result]);

        $this->assertCount(2, $return);
        $this->assertInstanceOf('Lunr\Spark\Twitter\Tweet', $return[0]);
    }

}

?>
