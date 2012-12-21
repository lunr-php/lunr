<?php

/**
 * This file contains the DBManTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DB
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Database\Tests;

use Lunr\Database\DBMan;

require_once 'conf.database.inc.php';

/**
 * This tests Lunr's DBMan class
 *
 * @category   Libraries
 * @package    DB
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Database\DBMan
 */
class DBManTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function get_db_connection().
     *
     * @covers Lunr\Database\DBMan::get_db_connection
     */
    public function testGetDbConnection()
    {
        global $db;
        $readonly = DBMan::get_db_connection($db);

        $this->assertTrue($readonly->is_readonly());
        unset($readonly);

        $readonly = DBMan::get_db_connection($db, TRUE);

        $this->assertTrue($readonly->is_readonly());
        unset($readonly);

        $readonly = DBMan::get_db_connection($db, FALSE);

        $this->assertFalse($readonly->is_readonly());
        unset($readonly);
    }

}

?>