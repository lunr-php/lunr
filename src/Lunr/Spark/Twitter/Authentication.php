<?php

/**
 * This file contains Authentication support for Twitter.
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
 * Twitter Authentication Support for Spark
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Twitter
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class Authentication extends Api
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
        $header = [
            'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'User-Agent' => $this->user_agent
        ];

        $options = [
            'CURLOPT_USERPWD' => $this->consumer_key . ':' . $this->consumer_secret,
            'CURLOPT_VERBOSE' => TRUE,
            'CURLOPT_SSL_VERIFYPEER' => TRUE
        ];

        $params = [
            'grant_type' => 'client_credentials'
        ];

        $this->curl->set_http_headers($header);
        $this->curl->set_options($options);

        $url = Domain::API . 'oauth2/token';

        $result = $this->get_json_results($url, $params, 'post');

        if (empty($result) === TRUE)
        {
            return '';
        }

        $this->bearer_token = $result['access_token'];

        return $result['access_token'];
    }

}

?>
