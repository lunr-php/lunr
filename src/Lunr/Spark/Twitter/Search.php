<?php

/**
 * This file contains Search support for Twitter.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

/**
 * Twitter Search Support for Spark
 */
class Search extends Api
{

    /**
     * Constructor.
     *
     * @param \Lunr\Spark\CentralAuthenticationStore $cas    Shared instance of the credentials store
     * @param \Psr\Log\LoggerInterface               $logger Shared instance of a Logger class.
     * @param \Requests_Session                      $http   Shared instance of the Requests_Session class.
     */
    public function __construct($cas, $logger, $http)
    {
        parent::__construct($cas, $logger, $http);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Fetches Tweets based on the search query and parameters.
     *
     * @param array $params The search url parameters
     *
     * @return array An array of Tweets
     */
    public function search_tweets($params)
    {
        $headers = [
            'Host'          => 'api.twitter.com',
            'Authorization' => 'Bearer ' . $this->bearer_token,
            'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
        ];

        $url = Domain::API . '1.1/search/tweets.json';

        $results = $this->get_json_results($url, $headers, $params);

        if (empty($results) === TRUE)
        {
            return [];
        }

        return $this->classify($results['statuses']);
    }

    /**
     * Turn the array of results to an object array of Tweets.
     *
     * @param array $data Array of tweet results
     *
     * @return array An array of Tweets
     */
    protected function classify($data)
    {
        if(!isset($data) || empty($data))
        {
            return;
        }

        $tweets = [];

        foreach($data as $tweet)
        {
            $tweet_obj = new Tweet();

            $tweets[] = $tweet_obj->set_data($tweet);
        }

        return $tweets;
    }

}

?>
