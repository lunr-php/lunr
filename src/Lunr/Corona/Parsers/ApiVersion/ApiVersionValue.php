<?php

/**
 * This file contains the API version request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion;

use Lunr\Corona\RequestEnumValueInterface;

/**
 * Request Data Enums
 */
enum ApiVersionValue: string implements RequestEnumValueInterface
{

    /**
     * API version
     */
    case ApiVersion = 'apiVersion';

}

?>
