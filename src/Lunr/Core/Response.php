<?php

/**
 * This file contains the response abstraction class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * Respone abstraction class.
 * Transport of data between Model/Controller and View
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
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
     * @var int
     */
    private $return_code;

    /**
     * Error message
     * @var String
     */
    private $errmsg;

    /**
     * Additional error info
     * @var String
     */
    private $errinfo;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data        = array();
        $this->errmsg      = '';
        $this->return_code = 0;
        $this->errinfo     = '';
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
            case 'return_code':
            case 'errmsg':
            case 'errinfo':
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
            case 'return_code':
                if (is_int($value))
                {
                    $this->return_code = $value;
                }

                return;
            case 'errmsg':
            case 'errinfo':
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

}

?>
