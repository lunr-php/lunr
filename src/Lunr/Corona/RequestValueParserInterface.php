<?php

/**
 * This file contains the request value parser interface.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;

/**
 * Request Value Parser Interface.
 */
interface RequestValueParserInterface
{

    /**
     * Return the request value type the parser handles.
     *
     * @return class-string The FQDN of the type enum the parser handles
     */
    public function get_request_value_type(): string;

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return scalar The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): bool|float|int|string|null;

}

?>
