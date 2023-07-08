<?php

/**
 * This file contains the response abstraction class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Respone abstraction class.
 * Transport of data between Model/Controller and View
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
     * @var string
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
     * @param string $name Attribute name
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
     * @param string $name  Attribute name
     * @param string $value Attribute value to set
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
     * @param string $identifier Call identifier
     * @param string $value      Error message
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
     * @param string $identifier Call identifier
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
     * @param string $identifier Call identifier
     * @param int    $value      Return code
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
    public function get_response_data($key = NULL)
    {
        if ($key === NULL)
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : NULL;
        }
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
        if (empty($this->return_code))
        {
            return NULL;
        }

        if ($identifier === NULL)
        {
            $identifier = array_search(max($this->return_code), $this->return_code);
        }

        return isset($this->return_code[$identifier]) ? $this->return_code[$identifier] : NULL;
    }

    /**
     * Get the set of return code identifiers.
     *
     * @param bool $max Only return the identifier of the highest error code (FALSE by default)
     *
     * @return string|array $return Requested set of identifiers.
     */
    public function get_return_code_identifiers($max = FALSE)
    {
        if (empty($this->return_code))
        {
            return [];
        }

        return $max ? array_search(max($this->return_code), $this->return_code) : array_keys($this->return_code);
    }

}

?>
