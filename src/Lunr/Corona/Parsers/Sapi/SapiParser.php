<?php

/**
 * This file contains the request value parser for the sapi
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Sapi;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for sapi
 */
class SapiParser implements RequestValueParserInterface
{

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
    public function getRequestValueType(): string
    {
        return SapiValue::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return string|null
     */
    public function get(BackedEnum&RequestValueInterface $key): ?string
    {
        return match ($key) {
            SapiValue::Sapi => PHP_SAPI,
            default         => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

}

?>
