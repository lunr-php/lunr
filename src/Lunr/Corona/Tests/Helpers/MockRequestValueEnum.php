<?php

/**
 * This file contains a mock request value enum.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests\Helpers;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;

/**
 * Request Data Enums
 */
enum MockRequestValueEnum: string implements ParsedEnumValueInterface
{

    /**
     * Mock value.
     */
    case Bar = 'bar';

    /**
     * Map scalar to an enum instance or NULL.
     *
     * This could just be an alias for BackedEnum::tryFrom(), but allows for more flexibility when needed.
     *
     * @param scalar|null $value The parsed request value
     *
     * @return BackedEnum&ParsedEnumValueInterface|null The requested value
     */
    public function tryFromRequestValue(int|string|null $value): ?BackedEnum
    {
        return $value === NULL ? NULL : $this->tryFrom($value);
    }

}

?>
