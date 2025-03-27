<?php

/**
 * This file contains a mock API version enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion\Tests\Helpers;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;

/**
 * Request Data Enums
 */
enum MockApiVersionEnum: int implements ParsedEnumValueInterface
{

    /**
     * Mock value.
     */
    case MOCK_1 = 1;

    /**
     * Map scalar to an enum instance or NULL.
     *
     * This could just be an alias for BackedEnum::tryFrom(), but allows for more flexibility when needed.
     *
     * @param scalar|null $value The parsed request value
     *
     * @return BackedEnum&ParsedEnumValueInterface|null The requested value
     */
    public static function tryFromRequestValue(int|string|null $value): ?BackedEnum
    {
        return $value === NULL ? NULL : self::tryFrom($value);
    }

}

?>
