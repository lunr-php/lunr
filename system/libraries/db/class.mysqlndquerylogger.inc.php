<?php

class MySQLndQueryLogger extends MySQLndUhConnection {

    public function __construct()
    {
//         var_dump(get_class_methods($this));
    }

    public function query($connection, $query)
    {
        $id = $this->get_function_call_hierarchy(xdebug_get_function_stack());
        $start = microtime();
        $return = parent::query($connection, $query);
        $time = microtime() - $start;
//         var_dump(parent::query($connection, $this->record_query_stats($id, $time)));
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

//     private function record_query_stats($identifier, $time)
//     {
//         $query  = "INSERT INTO stats_queries (`queryIdentifier`, `execTime`, `execDate`)";
//         $query .= " VALUES ('$identifier', $time, '" . M2DateTime::get_datetime() . "');";
//         return $query;
//     }

}

?>
