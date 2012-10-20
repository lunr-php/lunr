<?php

/**
 * This file contains the base Model class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Database\DBMan;

/**
 * Base Model class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class Model
{

    /**
     * Reference to the database connection
     * @var DBCon
     */
    protected $db;

    /**
     * The db configuration given on construction
     * @var array
     */
    protected $db_config;

    /**
     * Constructor.
     *
     * @param array $db The database configuration parameters
     */
    public function __construct($db)
    {
        $this->db = DBMan::get_db_connection($db);
        $this->db_config = $db;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->db);
    }

    /**
     * Get write access for the database.
     *
     * @return Boolean $return TRUE if successful, FALSE if there's already a
     *                         connection established
     */
    public function get_write_access()
    {
        $this->db = DBMan::get_db_connection($this->db_config, FALSE);
    }

    /**
     * Disconnect from the database.
     *
     * @return void
     */
    public function disconnect()
    {
        $this->db->disconnect();
    }

}

?>
