<?php

/**
 * This file contains the request value parser for the bearer token sourced from HTTP authorization headers.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\BearerToken;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the bearer token.
 */
class BearerTokenParser implements RequestValueParserInterface
{

    /**
     * The parsed bearerToken value.
     * @var string|null
     */
    protected readonly ?string $bearerToken;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // no-op
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Return the request value type the parser handles.
     *
     * @return class-string The FQDN of the type enum the parser handles
     */
    public function get_request_value_type(): string
    {
        return BearerTokenValue::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return string|null The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): ?string
    {
        return match ($key) {
            BearerTokenValue::BearerToken => $this->bearerToken ?? $this->parse(),
            default                       => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the bearer token value from the HTTP authorization header.
     *
     * @return string|null The parsed bearer token
     */
    protected function parse(): ?string
    {
        $token = NULL;

        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER))
        {
            $matches = [];
            if (preg_match('/^Bearer ([^ ]+)$/', $_SERVER['HTTP_AUTHORIZATION'], $matches) === 1)
            {
                $token = $matches[1];
            }
        }

        $this->bearerToken = $token;

        return $token;
    }

}

?>
