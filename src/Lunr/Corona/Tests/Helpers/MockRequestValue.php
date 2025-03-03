<?php

/**
 * This file contains mock request value types.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests\Helpers;

use Lunr\Corona\RequestEnumValueInterface;

/**
 * Request Data Enums
 */
enum MockRequestValue: string implements RequestEnumValueInterface
{

    /**
     * Mock value.
     */
    case Foo = 'foo';

}

?>
