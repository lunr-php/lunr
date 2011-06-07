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

namespace Lunr\Libraries\Database;

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
     * @var array
     */
    private static $ro_instance;

    /**
     * Instance of the dbcon class (read+write)
     * @var array
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
        if (!isset($db['driver']))
        {
            Output::error("Missing driver for '" . $db['database'] . "'! Defaulting to 'mysql'!");
            $db['driver'] = 'mysql';
        }

        if ($readonly === TRUE)
        {
            if (!isset(self::$ro_instance[$db['driver']]))
            {
                self::$ro_instance[$db['driver']] = DBConFactory::get_db_connection($db, $readonly);
            }

            return self::$ro_instance[$db['driver']];
        }
        else
        {
            if (!isset(self::$rw_instance[$db['driver']]))
            {
                self::$rw_instance[$db['driver']] = DBConFactory::get_db_connection($db, $readonly);
            }

            return self::$rw_instance[$db['driver']];
        }
    }

}

?>
