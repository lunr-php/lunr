<?php

/**
 * This file contains Authentication support for Twitter.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter;

/**
 * Twitter Authentication Support for Spark
 */
class Authentication extends Api
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
     * Retrieves the bearer access token from the twitter api.
     *
     * Allows a registered application to obtain an OAuth 2 Bearer Token,
     * which can be used to make API requests on an application's own behalf,
     * without a user context. This is called Application-only authentication.
     *
     * @return string The bearer access token
     */
    public function get_bearer_token()
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'User-Agent'   => $this->user_agent,
        ];

        $options = [
            'auth' => [
                $this->consumer_key,
                $this->consumer_secret,
            ],
        ];

        $params = ['grant_type' => 'client_credentials'];

        $url = Domain::API . 'oauth2/token';

        $result = $this->get_json_results($url, $headers, $params, 'POST', $options);

        if (empty($result) === TRUE)
        {
            return '';
        }

        $this->bearer_token = $result['access_token'];

        return $result['access_token'];
    }

}

?>
