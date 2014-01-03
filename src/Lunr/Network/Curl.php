<?php

/**
 * This file contains a Curl wrapper class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Curl
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * Curl wrapper class.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Curl
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Curl implements HttpRequestInterface
{

    /**
     * Curl options array
     * @var array
     */
    private $options;

    /**
     * HTTP Headers used by the Curl request
     * @var array
     */
    private $headers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reset_options();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->options);
        unset($this->headers);
    }

    /**
     * Reset options to default after a request.
     *
     * @return void
     */
    private function reset_options()
    {
        $this->options = array();
        $this->headers = array();

        // set default curl options
        $this->options[CURLOPT_TIMEOUT]        = 30;
        $this->options[CURLOPT_RETURNTRANSFER] = TRUE;
        $this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
        $this->options[CURLOPT_FAILONERROR]    = TRUE;
    }

    /**
     * Set multiple curl config options at once.
     *
     * @param array $options Array of curl config options
     *
     * @return Curl $self Self-reference
     */
    public function set_options($options)
    {
        if (!is_array($options))
        {
            return $this;
        }

        foreach ($options as $key => $value)
        {
            $this->set_option($key, $value);
        }

        return $this;
    }

    /**
     * Set a curl config option.
     *
     * @param String $key   Name of a curl config key
     * @param mixed  $value Value of that config options
     *
     * @return Curl $self Self-reference
     */
    public function set_option($key, $value)
    {
        if (substr($key, 0, 4) !== 'CURL')
        {
            return $this;
        }

        if (defined($key) === FALSE)
        {
            return $this;
        }

        $this->options[constant($key)] = $value;

        return $this;
    }

    /**
     * Set multiple additional HTTP headers to be used by the request.
     *
     * @param array $headers Array of HTTP Header Strings
     *
     * @return Curl $self Self-reference
     */
    public function set_http_headers($headers)
    {
        if (is_array($headers))
        {
            $this->headers = $headers + $this->headers;
        }

        return $this;
    }

    /**
     * Set additional HTTP headers to be used by the request.
     *
     * @param String $header Header String
     *
     * @return Curl $self Self-reference
     */
    public function set_http_header($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * Execute a curl request.
     *
     * @param String $uri URI for the request
     *
     * @return mixed $return Return value
     */
    private function execute($uri)
    {
        $handle = curl_init($uri);

        if (!empty($this->headers))
        {
            $this->set_option('CURLOPT_HTTPHEADER', $this->headers);
        }

        if (curl_setopt_array($handle, $this->options) !== TRUE)
        {
            $result = new CurlResponse(NULL, $handle);
        }
        else
        {
            $result = new CurlResponse(curl_exec($handle), $handle);
        }

        curl_close($handle);
        $this->reset_options();

        return $result;
    }

    /**
     * Retrieve remote content.
     *
     * @param String $uri Remote URI
     *
     * @return mixed $return Return value
     */
    public function get_request($uri)
    {
        return $this->execute($uri);
    }

    /**
     * Post data to a remote service.
     *
     * @param String $uri  Remote URI
     * @param mixed  $data Data to post
     *
     * @return mixed $return Return value
     */
    public function post_request($uri, $data)
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = 'POST';
        $this->options[CURLOPT_POST]          = TRUE;
        $this->options[CURLOPT_POSTFIELDS]    = $data;

        return $this->execute($uri);
    }

}

?>
