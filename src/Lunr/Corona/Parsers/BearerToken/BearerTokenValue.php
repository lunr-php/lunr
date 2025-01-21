<?php

/**
 * This file contains the bearer token request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\BearerToken;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum BearerTokenValue: string implements RequestValueInterface
{

    /**
     * Bearer token
     */
    case BearerToken = 'bearerToken';

}

?>
