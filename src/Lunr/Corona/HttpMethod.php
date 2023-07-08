<?php

/**
 * This file contains http methods.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
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
     * @var string
     */
    public const PATCH = 'PATCH';

}

?>
