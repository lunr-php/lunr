<?php

/**
 * This file contains http methods.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * HTTP methods.
 */
class HttpMethod
{

    /**
     * GET method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var String
     */
    const GET = 'GET';

    /**
     * HEAD method.
     *
     * Request has body:  no
     * Response has body: no
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var String
     */
    const HEAD = 'HEAD';

    /**
     * POST method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var String
     */
    const POST = 'POST';

    /**
     * PUT method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        yes
     *
     * @var String
     */
    const PUT = 'PUT';

    /**
     * DELETE method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              no
     * Idempotent:        yes
     *
     * @var String
     */
    const DELETE = 'DELETE';

    /**
     * CONNECT method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var String
     */
    const CONNECT = 'CONNECT';

    /**
     * OPTIONS method.
     *
     * Request has body:  optional
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var String
     */
    const OPTIONS = 'OPTIONS';

    /**
     * TRACE method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var String
     */
    const TRACE = 'TRACE';

    /**
     * PATCH method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var String
     */
    const PATCH = 'PATCH';

}

?>
