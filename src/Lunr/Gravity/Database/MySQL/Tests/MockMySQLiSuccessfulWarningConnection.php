<?php

/**
 * This file contains the MockMysqliSuccessfulWarningConnection class.
 *
 * SPDX-FileCopyrightText: Copyright 2021 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
