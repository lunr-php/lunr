<?php

/**
 * This file contains the TweetGetTweetDataTest class.
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Lunr\Spark\DataError;

/**
 * This class contains the tests for the Twitter Tweet class.
 *
 * @covers Lunr\Spark\Twitter\Tweet
 */
class TweetGetTweetDataTest extends TweetTest
{

    /**
     * Test that getting tweet data returns the data if it is present.
     *
     * @param string $field Field name
     *
     * @dataProvider tweetFieldsProvider
     * @covers       Lunr\Spark\Twitter\Tweet::__call
     */
    public function testGetTweetDataReturnsDataIfPresent($field)
    {
        $this->set_reflection_property_value('data', [ $field => 'Value' ]);

        $this->assertEquals('Value', $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting tweet data returns NOT_AVAILABLE if it is not present.
     *
     * @param string $field Field name
     *
     * @dataProvider tweetFieldsProvider
     * @covers       Lunr\Spark\Twitter\Tweet::__call
     */
    public function testGetTweetDataReturnsNotAvailableIfNotPresent($field)
    {
        $this->assertSame(DataError::NOT_AVAILABLE, $this->class->{'get_' . $field}());
    }

    /**
     * Test that getting tweet data returns UNKNOWN_FIELD in unkown field request.
     *
     * @covers Lunr\Spark\Twitter\Tweet::__call
     */
    public function testGetTweetDataReturnsUnknownDataErrorInUnkownField()
    {
        $this->assertSame(DataError::UNKNOWN_FIELD, $this->class->get_unkown());
    }

}

?>
