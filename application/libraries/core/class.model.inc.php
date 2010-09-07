<?php

/**
 * Base Model class
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class Model
{

    /**
     * Constructor
     */
    public function __construct()
    {
        require_once(dirname(__FILE__) . "/../db/class.dbcon.inc.php");
        require_once(dirname(__FILE__) . "/../db/class.query.inc.php");
    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

}

?>
