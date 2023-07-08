<?php

/**
 * This file contains http return codes.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * HTTP status codes.
 */
class HttpCode
{

    // Informational

    /**
     * The client should continue with its request, or ignore this if the request already completed.
     * @var int
     */
    public const SHOULD_CONTINUE = 100;

    /**
     * Server understands and is willing to upgrade the protocol used on the current connection.
     * @var int
     */
    public const SWITCHING_PROTOCOLS = 101;

    /**
     * An interim response used to inform the client that the server has accepted the complete request, but has not yet completed it.
     * @var int
     */
    public const PROCESSING = 102;

    // Successful

    /**
     * Request has succeeded.
     * @var int
     */
    public const OK = 200;

    /**
     * Request was fulfilled and new resource was created.
     * @var int
     */
    public const CREATED = 201;

    /**
     * Request was accepted for processing, but processing has not completed.
     * @var int
     */
    public const ACCEPTED = 202;

    /**
     * Returned meta-information is not definitive from the origin server, but gathered from local or third-party copy.
     * @var int
     */
    public const NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * Request was fulfilled but there is no need to return content.
     * @var int
     */
    public const NO_CONTENT = 204;

    /**
     * Request was fulfilled and client should reset the source which caused the request.
     * @var int
     */
    public const RESET_CONTENT = 205;

    /**
     * Request was acted upon and the requested partial content is returned.
     * @var int
     */
    public const PARTIAL_CONTENT = 206;

    // Redirection

    /**
     * Requested resource corresponds to any one of a set of representations.
     * @var int
     */
    public const MULTIPLE_CHOICES = 300;

    /**
     * Requested resource moved permanently to a different location.
     * @var int
     */
    public const MOVED_PERMANENTLY = 301;

    /**
     * Requested resource temporarily moved to a different location, but will return.
     * @var int
     */
    public const FOUND = 302;

    /**
     * Response of request can be found somewhere else.
     * @var int
     */
    public const SEE_OTHER = 303;

    /**
     * Requested resource has not been modified.
     * @var int
     */
    public const NOT_MODIFIED = 304;

    /**
     * Resource must be accessed using provided proxy.
     * @var int
     */
    public const USE_PROXY = 305;

    /**
     * Requested resource temporarily moved to a different location, but will return.
     * @var int
     */
    public const TEMPORARY_REDIRECT = 307;

    /**
     * The target resource has been assigned a new permanent URI and any future references to this resource ought to use one of the enclosed URIs.
     * @var int
     */
    public const PERMANENT_REDIRECT = 308;

    // Client Error

    /**
     * Request could not be understood due to malformed syntax.
     * @var int
     */
    public const BAD_REQUEST = 400;

    /**
     * The request requires authentication.
     * @var int
     */
    public const UNAUTHORIZED = 401;

    /**
     * The request requires payment.
     * @var int
     */
    public const PAYMENT_REQUIRED = 402;

    /**
     * Request understood, but refused to be fulfilled.
     * @var int
     */
    public const FORBIDDEN = 403;

    /**
     * Requested resource was not found.
     * @var int
     */
    public const NOT_FOUND = 404;

    /**
     * Requested method is not allowed on resource.
     * @var int
     */
    public const METHOD_NOT_ALLOWED = 405;

    /**
     * Resource can not return content in client acceptable form.
     * @var int
     */
    public const NOT_ACCEPTABLE = 406;

    /**
     * Request requires authentication with a proxy first.
     * @var int
     */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * Client did not produce request in reasonable timeframe.
     * @var int
     */
    public const REQUEST_TIMEOUT = 408;

    /**
     * Request could not be completed due to a conflict in the resource.
     * @var int
     */
    public const CONFLICT = 409;

    /**
     * Requested resource is no longer available and no forwarding address is known.
     * @var int
     */
    public const GONE = 410;

    /**
     * Request refused without provided Content Length.
     * @var int
     */
    public const LENGTH_REQUIRED = 411;

    /**
     * Provided precondition from the client failed.
     * @var int
     */
    public const PRECONDITION_FAILED = 412;

    /**
     * Request too large.
     * @var int
     */
    public const REQUEST_ENTITY_TOO_LARGE = 413;

    /**
     * Request URI too long.
     * @var int
     */
    public const REQUEST_URI_TOO_LONG = 414;

    /**
     * Requested resource does not understand request format.
     * @var int
     */
    public const UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * Requested partial content could not be served.
     * @var int
     */
    public const REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    /**
     * Client expectation could not be met.
     * @var int
     */
    public const EXPECTATION_FAILED = 417;

    /**
     * Client attempted to brew coffee with a teapot.
     * @var int
     */
    public const I_AM_A_TEAPOT = 418;

    /**
     * The request was directed at a server that is not able to produce a response.
     * @var int
     */
    public const MISDIRECTED_REQUEST = 421;

    /**
     * The server understands the content type of the request entity,
     * and the syntax of the request entity is correct but was unable to process the contained instructions.
     * @var int
     */
    public const UNPROCESSABLE_ENTITY = 422;

    /**
     * The source or destination resource of a method is locked.
     * @var int
     */
    public const LOCKED = 423;

    /**
     * The method could not be performed on the resource because the requested action depended on another action and that action failed.
     * @var int
     */
    public const FAILED_DEPENDENCY = 424;

    /**
     * The server refuses to perform the request using the current protocol
     * but might be willing to do so after the client upgrades to a different protocol.
     * @var int
     */
    public const UPGRADE_REQUIRED = 426;

    /**
     * The origin server requires the request to be conditional.
     * @var int
     */
    public const PRECONDITION_REQUIRED = 428;

    /**
     * The user has sent too many requests in a given amount of time ("rate limiting").
     * @var int
     */
    public const TOO_MANY_REQUESTS = 429;

    /**
     * The server is unwilling to process the request because its header fields are too large.
     * @var int
     */
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    // Server Error

    /**
     * Unexpected condition occured, preventing successful fulfillment.
     * @var int
     */
    public const INTERNAL_SERVER_ERROR = 500;

    /**
     * Server does not support functionality required to fulfill the request.
     * @var int
     */
    public const NOT_IMPLEMENTED = 501;

    /**
     * Server received invalid reply from third-party resource.
     * @var int
     */
    public const BAD_GATEWAY = 502;

    /**
     * Unable to fulfill request because of temporary overload or maintenance.
     * @var int
     */
    public const SERVICE_UNAVAILABLE = 503;

    /**
     * Server did not receive reply from third-party resource.
     * @var int
     */
    public const GATEWAY_TIMEOUT = 504;

    /**
     * Server does not support HTTP version used in the request.
     * @var int
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

}

?>
