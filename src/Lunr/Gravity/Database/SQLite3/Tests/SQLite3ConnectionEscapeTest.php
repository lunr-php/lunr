<?php

/**
 * This file contains the SQLite3ConnectionEscapeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains string escape unit tests for SQLite3Connection.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionEscapeTest extends SQLite3ConnectionTest
{

    /**
     * Test that escape_string() properly escapes the given string.
     *
     * @param string $string       String to escape
     * @param string $part_escaped Partially escaped string (as returned by escapeString)
     * @param string $escaped      Expected escaped string
     *
     * @dataProvider escapeStringProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3Connection::escape_string
     */
    public function testEscapeString($string, $part_escaped, $escaped): void
    {
        $method = [ get_class($this->sqlite3), 'escapeString' ];

        $this->mock_method($method, function () use ($escaped) { return $escaped;});

        $value = $this->class->escape_string($string);

        $this->assertEquals($escaped, $value);

        $this->unmock_method($method);
    }

}

?>
