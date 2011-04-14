<?php

require_once("class.dbman.inc.php");
require_once("class.dbcon.inc.php");
require_once("class.dbconmysql.inc.php");
require_once("class.dbconfactory.inc.php");
require_once("conf.database.inc.php");

/**
 * This tests Lunr's DBMan class
 * @covers DBMan
 */
class DBManTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function get_db_connection()
     * @covers DBMan::get_db_connection
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