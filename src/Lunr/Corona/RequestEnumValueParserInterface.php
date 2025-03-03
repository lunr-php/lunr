<?php

/**
 * This file contains the request enum value parser interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;

/**
 * Request Enum Value Parser Interface.
 */
interface RequestEnumValueParserInterface extends RequestValueParserInterface
{

    /**
     * Get a request value as an enum.
     *
     * @param BackedEnum&RequestEnumValueInterface $key The identifier/name of the request value to get
     *
     * @return BackedEnum|null The requested value
     */
    public function getAsEnum(BackedEnum&RequestEnumValueInterface $key): ?BackedEnum;

}

?>
