<?php

/**
 * This file contains the FeedBaseTest class.
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

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains the tests for the Facebook Feed class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\Facebook\Feed
 */
class FeedBaseTest extends FeedTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the CentralAuthenticationStore class is passed correctly.
     */
    public function testCasIsSetCorrectly()
    {
        $this->assertPropertySame('cas', $this->cas);
    }

    /**
     * Test that the Curl class is passed correctly.
     */
    public function testCurlIsSetCorrectly()
    {
        $this->assertPropertySame('curl', $this->curl);
    }

    /**
     * Test that limit is initialized with 25.
     */
    public function testLimitIsSetCorrect()
    {
        $this->assertPropertySame('limit', 25);
    }

    /**
     * Test that next is initialized with 0.
     */
    public function testNextIsSetToZero()
    {
        $this->assertPropertySame('next', 0);
    }

    /**
     * Test that previous is initialized with 0.
     */
    public function testPreviousIsSetToZero()
    {
        $this->assertPropertySame('previous', 0);
    }

    /**
     * Test that fetched_user_data is initialized FALSE.
     */
    public function testFetchedUserDataIsFalse()
    {
        $this->assertFalse($this->get_reflection_property_value('fetched_user_data'));
    }

    /**
     * Test that set_limit() sets the limit correctly.
     *
     * @covers Lunr\Spark\Facebook\Feed::set_limit
     */
    public function testSetLimitSetsLimit()
    {
        $this->class->set_limit(100);

        $this->assertPropertySame('limit', 100);
    }

    /**
     * Test that get_posts() returns all fetched posts.
     *
     * @covers Lunr\Spark\Facebook\Feed::get_posts
     */
    public function testGetPostsGetsData()
    {
        $posts = [ [], [], [] ];

        $this->set_reflection_property_value('data', $posts);

        $this->assertSame($posts, $this->class->get_posts());
    }

}

?>
