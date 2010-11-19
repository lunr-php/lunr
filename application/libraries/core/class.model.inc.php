<?php

/**
 * Base Model class
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class Model
{

    /**
     * Reference to the database connection
     * @var DBCon
     */
    protected $db;

    /**
     * Constructor
     */
    public function __construct($db)
    {
        require_once("class.dbcon.inc.php");
        require_once("class.query.inc.php");
        $this->db = DBCon::get_db_connection($db);
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->db);
    }

    /**
     * Get write access for the database
     * @return Boolean $return TRUE if successful, FALSE if there's already a connection established
     */
    public function get_write_access()
    {
        return $this->db->set_writeable();
    }

}

?>
