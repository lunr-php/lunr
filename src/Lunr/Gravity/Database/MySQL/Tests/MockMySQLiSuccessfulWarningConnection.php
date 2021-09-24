<?php

/**
 * This file contains the MockMysqliSuccessfulWarningConnection class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Brian Stoop <b.stoop@m2mobi.com>
 * @copyright  2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class is a wrapper around MySQLi for a successful connection with warnings.
 */
class MockMySQLiSuccessfulWarningConnection extends MockMySQLiSuccessfulConnection
{

    /**
     * Fake giving mysqli_warnings
     *
     * @return MockMySQLiWarning $return mockmysqli_warnings for no warnings on successfull query.
     */
    public function get_warnings()
    {
        $mysqli_warning = new MockMySQLiWarning("Data truncated for column 'a' at row 1", 'HY000', 1265, FALSE);

        return new MockMySQLiWarning("Field 'c' doesn't have a default value", 'HY000', 1364, $mysqli_warning);
    }

}

?>
