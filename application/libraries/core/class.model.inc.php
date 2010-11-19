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

}

?>
