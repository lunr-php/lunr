<?php

/**
 * Output library
 * @author M2Mobi, Heinz Wiesinger
 */
class Output
{

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * Print given message immediatly
     * @param String $msg Message to print
     * @return void
     */
    public static function cli_print($msg)
    {
        require_once("class.m2datetime.inc.php");
        echo M2DateTime::get_datetime() . ": " . $msg;
    }

    /**
     * Print status information ([ok] or [failed])
     * @param String $msg Message to print
     * @return void
     */
    public static function cli_print_status($bool)
    {
        require_once("class.m2datetime.inc.php");
        if ($bool === TRUE)
        {
            echo "[ok]\n";
        }
        else
        {
            echo "[failed]\n";
        }
    }

    /**
     * Print given message immediatly
     * @param String $msg Message to print
     * @return void
     */
    public static function cli_println($msg)
    {
        require_once("class.m2datetime.inc.php");
        echo M2DateTime::get_datetime() . ": " . $msg . "\n";
    }

    /**
     * Trigger a PHP error
     * @param String $info The error string that should be printed
     * @return void
     */
    public static function error($info)
    {
        if (isset($_GET['controller']) && isset($_GET['method']))
        {
            trigger_error($_GET['controller'] . "/" . $_GET['method'] . ": " . $info);
        }
        else
        {
            trigger_error($info);
        }
    }

}

?>
