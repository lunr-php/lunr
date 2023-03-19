<?php
/**
 * This file contains the DummyDeadlockException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests\Helpers;

use Lunr\Gravity\Database\Exceptions\DatabaseException;
use Lunr\Gravity\Database\Exceptions\DeadlockException;

/**
 * Dummy exception to test a database query error.
 */
class DummyDeadlockException extends DeadlockException
{

    /**
     * Constructor.
     *
     * @param string $message The exception message
     */
    public function __construct(string $message = 'Dummy Deadlock!')
    {
        // Skip over the parent constructor to avoid having to specify the QueryResult class
        DatabaseException::__construct($message);
    }

}

?>
