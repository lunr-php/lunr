<?php

/**
 * This file contains the response abstraction class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Respone abstraction class.
 * Transport of data between Model/Controller and View
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Response
{

    /**
     * Data store
     * @var array
     */
    private $data;

    /**
     * Return code
     * @var array
     */
    private $return_code;

    /**
     * Error message
     * @var array
     */
    private $errmsg;

    /**
     * Additional error info
     * @var array
     */
    private $errinfo;

    /**
     * The selected view to display the data.
     * @var String
     */
    private $view;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data        = [];
        $this->errmsg      = [];
        $this->return_code = [];
        $this->errinfo     = [];
        $this->view        = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->data);
        unset($this->errmsg);
        unset($this->return_code);
        unset($this->errinfo);
        unset($this->view);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to the error information and the return code.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'view':
                return $this->$name;
            default:
                return NULL;
        }
    }

    /**
     * Set values for return code and error information.
     *
     * @param String $name  Attribute name
     * @param String $value Attribute value to set
     *
     * @return void
     */
    public function __set($name, $value)
    {
        switch ($name)
        {
            case 'view':
                $this->$name = $value;
                return;
            default:
                return;
        }
    }

    /**
     * Add response data for later processing by a view.
     *
     * @param mixed $key   Identifier for the data
     * @param mixed $value The data
     *
     * @return void
     */
    public function add_response_data($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Set an error message for the given call identifier.
     *
     * @param String $identifier Call identifier
     * @param String $value      Error message
     *
     * @return void
     */
    public function set_error_message($identifier, $value)
    {
        $this->errmsg[$identifier] = $value;
    }

    /**
     * Set additional error information for the given call identifier.
     *
     * @param String $identifier Call identifier
     * @param mixed  $value      Additional error information
     *
     * @return void
     */
    public function set_error_info($identifier, $value)
    {
        $this->errinfo[$identifier] = $value;
    }

    /**
     * Set a return code for the given call identifier.
     *
     * @param String  $identifier Call identifier
     * @param Integer $value      Return code
     *
     * @return void
     */
    public function set_return_code($identifier, $value)
    {
        if (is_int($value) === TRUE)
        {
            $this->return_code[$identifier] = $value;
        }
    }

    /**
     * Get a specific response data.
     *
     * @param mixed $key Identifier for the data
     *
     * @return mixed $value The matching data on success, or NULL on failure
     */
    public function get_response_data($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : NULL;
    }

    /**
     * Get error message for a call identifier.
     *
     * @param mixed $identifier Call identifier
     *
     * @return mixed $value The matching error message on success, or NULL on failure
     */
    public function get_error_message($identifier)
    {
        return isset($this->errmsg[$identifier]) ? $this->errmsg[$identifier] : NULL;
    }

    /**
     * Get error info for a call identifier.
     *
     * @param mixed $identifier Call identifier
     *
     * @return mixed $value The matching error info on success, or NULL on failure
     */
    public function get_error_info($identifier)
    {
        return isset($this->errinfo[$identifier]) ? $this->errinfo[$identifier] : NULL;
    }

    /**
     * Get return code for most severe error, or for call identifier if given.
     *
     * @param mixed $identifier Call identifier
     *
     * @return mixed $value The matching return code on success, or NULL on failure
     */
    public function get_return_code($identifier = NULL)
    {
        if ($identifier === NULL)
        {
            $identifier = array_search(max($this->return_code), $this->return_code);
        }

        return isset($this->return_code[$identifier]) ? $this->return_code[$identifier] : NULL;
    }

}

?>
