<?php

class MySQLndQueryLogger extends MySQLndUhConnection {

    public function query($connection, $query)
    {
        $id = $this->get_function_call_hierarchy(xdebug_get_function_stack());

        $start = microtime();
        $return = parent::query($connection, $query);
        $time = microtime() - $start;

        $this->record_query_stats($id, $time);

        return $return;
    }

    private function get_function_call_hierarchy($stack)
    {
        $hierarchy = "";
        foreach ($stack as &$value)
        {
            if (isset($value['class']))
            {
                $hierarchy .= $value['class'] . "->" . $value['function'] . "()=>";
            }
            else
            {
                $hierarchy .= $value['function'] . "()=>";
            }
        }
        unset($value);

        $hierarchy = trim($hierarchy,"=>");
        return $hierarchy;
    }

    private function record_query_stats($identifier, $time)
    {
        global $stats_db;
        $sqlite = DBMan::get_db_connection($stats_db, FALSE);

        $data = array(
                    "queryIdentifier" => $identifier,
                    "execTime" => $time,
                    "execDate" => M2DateTime::get_datetime()
                );
        $sqlite->insert("query_stats", $data);
    }

}

?>
