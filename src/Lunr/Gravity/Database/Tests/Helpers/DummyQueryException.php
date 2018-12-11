<?php
/**
 * This file contains the DummyQueryException class.
 *
 * @package   Lunr\Gravity\Database
 * @author    Patrick Valk <p.valk@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests\Helpers;

use Lunr\Gravity\Database\Exceptions\QueryException;

/**
 * Dummy exception to test a database query error.
 */
class DummyQueryException extends QueryException
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // empty constructor to override input values for testing.
    }

}

?>
