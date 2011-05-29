<?php

include_once("conf.database.inc.php");

/**
 * This tests Lunr's DBMan class
 * @covers DBMan
 */
class DBManTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        include_once("class.dbman.inc.php");
        include_once("class.dbcon.inc.php");
        include_once("class.dbconmysql.inc.php");
        include_once("class.dbconfactory.inc.php");
    }

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