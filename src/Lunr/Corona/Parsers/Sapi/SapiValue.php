<?php

/**
 * This file contains the sapi value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Sapi;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum SapiValue: string implements RequestValueInterface
{

    /**
     * Sapi
     */
    case Sapi = 'sapi';

}

?>
