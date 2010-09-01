<?php

abstract class Controller
{

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function __call($name, $arguments)
    {
        return Json::error("not_implemented");
    }

    abstract public function index();

}

?>
