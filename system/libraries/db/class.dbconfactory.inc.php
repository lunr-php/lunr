<?php

/**
 * This file contains a factory for the different database
 * connection drivers.
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
 * Database connection driver factory
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class DBConFactory
{

    /**
     * Returns a database connection based on the input.
     *
     * @param array   $db       Database configuration values
     * @param Boolean $readonly Whether to return a readonly connection or not
     *
     * @return DBCon $db Reference to a new database connection driver
     */
    public static function get_db_connection($db, $readonly)
    {
        if (!isset($db['driver']))
        {
            $db['driver'] = "";
        }

        switch ($db['driver'])
        {
            case "mysql":
            default:
                return new DBConMySQL($db, $readonly);
                break;
        }
    }
}

?>
