<?php

/**
 * HTTP request interface.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * HTTP request interface.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface HttpRequestInterface
{

    /**
     * Set multiple additional HTTP headers to be used by the request.
     *
     * @param array $headers Array of HTTP Header Strings
     *
     * @return HttpRequestInterface $self Self-reference
     */
    public function set_http_headers($headers);

    /**
     * Set additional HTTP headers to be used by the request.
     *
     * @param String $header Header String
     *
     * @return HttpRequestInterface $self Self-reference
     */
    public function set_http_header($header);

    /**
     * Retrieve remote content.
     *
     * @param String $uri Remote URI
     *
     * @return mixed $return Return value
     */
    public function get_request($uri);

    /**
     * Post data to a remote URI.
     *
     * @param String $uri  Remote URI
     * @param mixed  $data Data to post
     *
     * @return mixed $return Return value
     */
    public function post_request($uri, $data);

}

?>
