<?php

/**
 * This file contains http methods.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
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
    public const GET = 'GET';

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
    public const HEAD = 'HEAD';

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
    public const POST = 'POST';

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
    public const PUT = 'PUT';

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
    public const DELETE = 'DELETE';

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
    public const CONNECT = 'CONNECT';

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
    public const OPTIONS = 'OPTIONS';

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
    public const TRACE = 'TRACE';

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
    public const PATCH = 'PATCH';

}

?>
