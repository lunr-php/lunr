<?php
/**
 * This file contains the LockTimeoutException class.
 *
 * SPDX-FileCopyrightText: Copyright 2021 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Exceptions;

/**
 * Exception for a database query deadlock.
 */
class LockTimeoutException extends DeadlockException
{

}

?>
