<?php

/**
 * This file contains the SQLite3ConnectionEscapeTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;

/**
 * This class contains string escape unit tests for SQLite3Connection.
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionEscapeTest extends SQLite3ConnectionTest
{

    /**
     * Test that escape_string() properly escapes the given string.
     *
     * @param String $string       String to escape
     * @param String $part_escaped Partially escaped string (as returned by escapeString)
     * @param String $escaped      Expected escaped string
     *
     * @dataProvider escapeStringProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3Connection::escape_string
     */
    public function testEscapeString($string, $part_escaped, $escaped)
    {
        $this->sqlite3->staticExpects($this->once())
                      ->method('escapeString')
                      ->will($this->returnValue($escaped));

        $value = $this->class->escape_string($string);

        $this->assertEquals($escaped, $value);
    }

}

?>
