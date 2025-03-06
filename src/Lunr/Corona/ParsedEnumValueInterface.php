<?php

/**
 * This file contains the interface for parsed enum values.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;

/**
 * Parsed Enum Value Interface.
 */
interface ParsedEnumValueInterface
{

    /**
     * Map scalar to an enum instance or NULL.
     *
     * This could just be an alias for BackedEnum::tryFrom(), but allows for more flexibility when needed.
     *
     * @param int|string|null $value The parsed request value
     *
     * @return BackedEnum|null The requested value
     */
    public function tryFromRequestValue(int|string|null $value): ?BackedEnum;

}

?>
