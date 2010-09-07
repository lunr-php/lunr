<?php

/**
 * View class used by the Website
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class View
{

    /**
     * Shared data variable
     * @var array
     */
    protected $data;

    /**
     * Reference to the Controller who instantiated the View
     * @var Controller
     */
    protected $controller;

    /**
     * Constructor
     * @param Object $controller Reference to the controller
     */
    public function __construct(&$controller)
    {
        $this->data = array();
        $this->controller = &$controller;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * Build the actual display and print it
     */
    abstract public function print_page();

    /**
     * Add data to the view, which is then accessible from within
     * the print_page() function.
     * @param Mixed $key Identifier for the data
     * @param Mixed $value The data
     */
    public function add_data($key, &$value)
    {
        $this->data[$key] = &$value;
    }

}

?>
