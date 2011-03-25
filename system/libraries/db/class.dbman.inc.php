<?php

/**
 * This file contains a Database Connection Manager
 * class, managing database read and write connections
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * Database connection manager class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class DBMan
{

    /**
     * Instance of the dbcon class (readonly)
     * @var DBCon
     */
    private static $ro_instance;

    /**
     * Instance of the dbcon class (read+write)
     * @var DBCon
     */
    private static $rw_instance;

    /**
     * Return an instance of dbcon.
     *
     * @param array   $db       Database configuration values
     * @param Boolean $readonly Whether to return a readonly connection or not
     *
     * @return DBCon Reference to the DBCon Singleton
     */
    public static function get_db_connection($db, $readonly = TRUE)
    {
        require_once("class.dbcon.inc.php");
        require_once("class.query.inc.php");
        if ($readonly === TRUE)
        {
            if (!isset(self::$ro_instance))
            {
                self::$ro_instance = new DBCon($db, TRUE);
            }

            return self::$ro_instance;
        }
        else
        {
            if (!isset(self::$rw_instance))
            {
                self::$rw_instance = new DBCon($db, FALSE);
            }

            return self::$rw_instance;
        }
    }

}

?>
