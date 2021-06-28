<?php
/**
 * This file contains the LockTimeoutException class.
 *
 * @package   Lunr\Gravity\Database\Exceptions
 * @author    Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright 2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Exceptions;

/**
 * Exception for a database query deadlock.
 */
class LockTimeoutException extends DeadlockException
{

}

?>
