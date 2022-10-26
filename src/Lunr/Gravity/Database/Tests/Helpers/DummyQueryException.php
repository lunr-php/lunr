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

use Lunr\Gravity\Database\Exceptions\DatabaseException;
use Lunr\Gravity\Database\Exceptions\QueryException;

/**
 * Dummy exception to test a database query error.
 */
class DummyQueryException extends QueryException
{

    /**
     * Constructor.
     *
     * @param string $message The exception message
     */
    public function __construct(string $message = 'Dummy Query error!')
    {
        // Skip over the parent constructor to avoid having to specify the QueryResult class
        DatabaseException::__construct($message);
    }

}

?>
