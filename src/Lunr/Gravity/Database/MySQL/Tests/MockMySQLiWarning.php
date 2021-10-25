<?php

/**
 * This file contains the MockMysqliWarning class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Brian Stoop <b.stoop@m2mobi.com>
 * @copyright  2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class is a Mock for the mysqli_warning class.
 */
class MockMySQLiWarning
{

    /**
     * The MySQL warning message
     * @var string
     */
    public $message;

    /**
     * The MySQL warning sql state
     * @var string
     */
    public $sqlstate;

    /**
     * The MySQL warning error code
     * @var Integer
     */
    public $errno;

    /**
     * The next MockMySQLiWarning or FALSE if no next warning for the next() method
     * @var MockMySQLiWarning|boolean
     */
    public $next_warning;

    /**
     * Constructor.
     *
     * @param string                 $message      Message of the warning
     * @param string                 $sqlstate     Sqlstate of the warning
     * @param int                    $errno        Error number of the warning
     * @param MockMySQLiWarning|bool $next_warning Next warning for the next() method
     */
    public function __construct($message, $sqlstate, $errno, $next_warning)
    {
        $this->message      = $message;
        $this->sqlstate     = $sqlstate;
        $this->errno        = $errno;
        $this->next_warning = $next_warning;
    }

    /**
     * Mock of the next() method of mysqli_warning
     *
     * @return bool Returns TRUE if there is a next warning
     *                 Or FALSE if there is no next warning
     */
    public function next()
    {
        if (!$this->next_warning)
        {
            return FALSE;
        }

        $this->message      = $this->next_warning->message;
        $this->sqlstate     = $this->next_warning->sqlstate;
        $this->errno        = $this->next_warning->errno;
        $this->next_warning = $this->next_warning->next_warning;

        return TRUE;
    }

}
