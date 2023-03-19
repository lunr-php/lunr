<?php

/**
 * Lunr wrapper around the SQLite3 class, that doesn't connect on construct.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3;

use SQLite3;

/**
 * Wrapper class around SQLite3.
 */
class LunrSQLite3 extends SQLite3
{

    /**
     * Contructor.
     */
    public function __construct()
    {
        // empty constructor to override connect on construction.
    }

}

?>
