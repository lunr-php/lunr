<?php

/**
 * This file contains Search support for Twitter.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

/**
 * Twitter Search Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class Search extends Api
{

    /**
     * Constructor.
     *
     * @param CentralAuthenticationStore $cas    Shared instance of the CentralAuthenticationStore class.
     * @param LoggerInterface            $logger Shared instance of a Logger class.
     * @param Curl                       $curl   Shared instance of the Curl class.
     */
    public function __construct($cas, $logger, $curl)
    {
        parent::__construct($cas, $logger, $curl);
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
        $header = [
            'Host: api.twitter.com',
            'Authorization: Bearer ' . $this->bearer_token,
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        ];

        $this->curl->set_http_headers($header);
        $this->curl->set_option('CURLOPT_ENCODING', 'gzip');

        $url = Domain::API . '1.1/search/tweets.json';

        $results = $this->get_json_results($url, $params);

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
