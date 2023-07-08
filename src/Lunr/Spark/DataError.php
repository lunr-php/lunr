<?php

/**
 * This file contains data error types.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark;

/**
 * Spark module data error types.
 */
class DataError
{

    /**
     * Unknown data field.
     * @var String
     */
    public const UNKNOWN_FIELD = 'E0';

    /**
     * Field data is not available.
     * @var String
     */
    public const NOT_AVAILABLE = 'E1';

    /**
     * Field data was not requested.
     * @var String
     */
    public const NOT_REQUESTED = 'E2';

    /**
     * Access to field data denied.
     * @var String
     */
    public const ACCESS_DENIED = 'E3';

}

?>
