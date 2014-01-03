<?php

/**
 * This file contains the Tweet class.
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

use Lunr\Spark\Twitter\Tweet;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the Twitter Tweet class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Spark\Twitter\Tweet
 */
abstract class TweetTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->class      = new Tweet();
        $this->reflection = new ReflectionClass('Lunr\Spark\Twitter\Tweet');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for tweet fields.
     *
     * @return array $fields Array of fields.
     */
    public function tweetFieldsProvider()
    {
        $fields   = [];
        $fields[] = [ 'annotations' ];
        $fields[] = [ 'contributors' ];
        $fields[] = [ 'coordinates' ];
        $fields[] = [ 'created_at' ];
        $fields[] = [ 'current_user_retweet' ];
        $fields[] = [ 'entities' ];
        $fields[] = [ 'favorite_count' ];
        $fields[] = [ 'favorited' ];
        $fields[] = [ 'filter_level' ];
        $fields[] = [ 'id' ];
        $fields[] = [ 'id_str' ];
        $fields[] = [ 'in_replay_to_screen_name' ];
        $fields[] = [ 'in_replay_to_status_id' ];
        $fields[] = [ 'in_replay_to_status_id_str' ];
        $fields[] = [ 'in_replay_to_user_id' ];
        $fields[] = [ 'in_replay_to_user_id_str' ];
        $fields[] = [ 'lang' ];
        $fields[] = [ 'place' ];
        $fields[] = [ 'possibly_sensitive' ];
        $fields[] = [ 'scopes' ];
        $fields[] = [ 'retweeted' ];
        $fields[] = [ 'retweeted_status' ];
        $fields[] = [ 'source' ];
        $fields[] = [ 'text' ];
        $fields[] = [ 'truncated' ];
        $fields[] = [ 'user' ];
        $fields[] = [ 'withheld_copyright' ];
        $fields[] = [ 'withheld_in_countries' ];
        $fields[] = [ 'withheld_scope' ];

        return $fields;
    }

}

?>
